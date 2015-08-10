<?php

namespace Vokativ;

class Vokativ
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
        return "";
    }

    /**
     * Na základě jména nebo přijmení rozhodne o pohlaví
     * @param string $name Jméno v prvním pádu
     * @return boolean Rozhodne, jeslti je jméno mužské
     */
    public static function isMale($name)
    {
        return true;
    }
}