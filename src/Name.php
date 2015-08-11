<?php

namespace Vokativ;

use \InvalidArgumentException;
define(
    'VOKATIV_DATA_DIR',
    dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
);

class Name
{
    /**
     * Vrací jméno vyskloňované do 5. pádu
     * @param string $name Jméno v původním tvaru
     * @param boolean|null $isWoman
     * @param boolean|null $isLastName
     * @return string Jméno v 5. pádu
     */
    public static function vokativ($name, $isWoman = null, $isLastName = null)
    {
        if(gettype($name) !== "string")
            throw new InvalidArgumentException('`$name` has to be string');
        $name = mb_strtolower($name);

        if (is_null($isWoman)) {
            $isWoman = !self::isMale($name);
        }

        if ($isWoman) {
            if (is_null($isLastName)) {
                list($match, $type) = self::getMatchingSuffix(
                    $name,
                    self::getWomanFirstVsLastNameSuffixes()
                );

                $isLastName = $type != 'l' ? false : true;
            }

            if ($isLastName) {
                return self::vokativWomanLastName($name);
            }
            return self::vokativWomanFirstName($name);
        }

        return self::vokativMan($name);
    }

    /**
     * Na základě jména nebo přijmení rozhodne o pohlaví
     * @param string $name Jméno v prvním pádu
     * @return boolean Rozhodne, jeslti je jméno mužské
     */
    public static function isMale($name)
    {
        if(gettype($name) !== "string")
            throw new InvalidArgumentException('`$name` has to be string');
        $name = mb_strtolower($name);

        list($match, $sex) = self::getMatchingSuffix(
            $name,
            self::getManVsWomanSuffixes()
        );

        return $sex === "w" ? false : true ;
    }

    protected static function vokativMan($name)
    {
        list($match, $suffix) = self::getMatchingSuffix(
            $name,
            self::getManSuffixes()
        );

        if ($match) {
            $name = mb_substr($name, 0, -1 * mb_strlen($match));
        }

        return $name . $suffix;
    }

    protected static function vokativWomanFirstName($name)
    {
        if(mb_substr($name, -1) === "a")
            return mb_substr($name, 0, -1) . "o";
        return $name;
    }

    protected static function vokativWomanLastName($name)
    {
        return $name;
    }

    protected static function getMatchingSuffix($name, $suffixes)
    {
        // it is important(!) to try suffixes from longest to shortest
        foreach (range(mb_strlen($name), 1) as $length) {
            $suffix = mb_substr($name, -1 * $length);
            if (array_key_exists($suffix, $suffixes)) {
                return [$suffix, $suffixes[$suffix]];
            }
        }
        return ['', $suffixes['']];
    }

    protected static $_manSuffixes = null;
    protected static $_manVsWomanSuffixes = null;
    protected static $_womanFirstVsLastSuffixes = null;

    protected static function getManSuffixes()
    {
        if(is_null(self::$_manSuffixes))
            self::$_manSuffixes = self::readSuffixes('man_suffixes');
        return self::$_manSuffixes;
    }

    protected static function getManVsWomanSuffixes()
    {
        if(is_null(self::$_manVsWomanSuffixes))
            self::$_manVsWomanSuffixes =
                self::readSuffixes('man_vs_woman_suffixes');
        return self::$_manVsWomanSuffixes;
    }

    protected static function getWomanFirstVsLastNameSuffixes()
    {
        if(is_null(self::$_womanFirstVsLastSuffixes))
            self::$_womanFirstVsLastSuffixes =
                self::readSuffixes('woman_first_vs_last_name_suffixes');
        return self::$_womanFirstVsLastSuffixes;
    }

    protected static function readSuffixes($file)
    {
        $filename = VOKATIV_DATA_DIR . $file;
        if(!file_exists($filename))
            throw new RuntimeException('VOKATIV: Data file ' . $filename . 'not found');
        return unserialize(file_get_contents($filename));
    }
}