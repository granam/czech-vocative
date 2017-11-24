<?php
namespace Granam\CzechVocative;

class CzechName
{
    /**
     * Vrací jméno vyskloňované do 5. pádu
     * @param string $name Jméno v původním tvaru
     * @param boolean|null $isWoman
     * @param boolean|null $isLastName
     * @return string Jméno v 5. pádu
     */
    public function vocative(string $name, bool $isWoman = null, bool $isLastName = null): string
    {
        $name = trim($name);
        if (preg_match('~[^[:alpha:]]$~u', $name)) {
            return $name; // name with trailing non-letter is left untouched
        }
        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
        $key = mb_strtolower($name, 'UTF-8');

        if ($isWoman === null) {
            $isWoman = !$this->isMale($key);
        }

        if ($isWoman) {
            if ($isLastName === null) {
                list(, $type) = $this->getMatchingSuffix(
                    $key,
                    $this->getWomanFirstVsLastNameSuffixes()
                );

                $isLastName = $type === 'l';
            }

            if ($isLastName) {
                return $this->vocativeWomanLastName($name);
            }

            return $this->vocativeWomanFirstName($name);
        }

        return $this->vocativeMan($name, $key);
    }

    /**
     * Na základě jména nebo přijmení rozhodne o pohlaví
     * @param string $name Jméno v prvním pádu
     * @return boolean Rozhodne, jestli je jméno mužské
     */
    public function isMale(string $name): bool
    {
        $name = mb_strtolower($name, 'UTF-8');

        list(, $sex) = $this->getMatchingSuffix(
            $name,
            $this->getManVsWomanSuffixes()
        );

        return $sex !== 'w';
    }

    private function vocativeMan(string $name, string $key): string
    {
        list($match, $suffix) = $this->getMatchingSuffix(
            $key,
            $this->getManSuffixes()
        );

        if ($match) {
            $name = mb_substr($name, 0, -1 * mb_strlen($match));
        }
        $name .= $suffix;

        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }

    private function vocativeWomanFirstName(string $name): string
    {
        if (mb_substr($name, -1) === 'a') {
            return mb_substr($name, 0, -1) . 'o';
        }

        return $name;
    }

    private function vocativeWomanLastName(string $name): string
    {
        return $name;
    }

    /**
     * @param string $name
     * @param array $suffixes
     * @return array
     */
    private function getMatchingSuffix(string $name, array $suffixes): array
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

    private $_manSuffixes;
    private $_manVsWomanSuffixes;
    private $_womanFirstVsLastSuffixes;

    private function getManSuffixes(): array
    {
        if ($this->_manSuffixes === null) {
            $this->_manSuffixes = $this->readSuffixes('man_suffixes');
        }

        return $this->_manSuffixes;
    }

    private function readSuffixes(string $file): array
    {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $file;

        return \unserialize(\file_get_contents($filename), ['allowed_classes' => false]);
    }

    private function getManVsWomanSuffixes(): array
    {
        if ($this->_manVsWomanSuffixes === null) {
            $this->_manVsWomanSuffixes = $this->readSuffixes('man_vs_woman_suffixes');
        }

        return $this->_manVsWomanSuffixes;
    }

    private function getWomanFirstVsLastNameSuffixes(): array
    {
        if ($this->_womanFirstVsLastSuffixes === null) {
            $this->_womanFirstVsLastSuffixes = $this->readSuffixes('woman_first_vs_last_name_suffixes');
        }

        return $this->_womanFirstVsLastSuffixes;
    }

}
