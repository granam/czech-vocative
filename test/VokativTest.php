<?php
namespace Vokativ\Test;

use Vokativ\Name;
use PHPUnit_Framework_TestCase;

define(
    "VOKATIV_TEST_DIR",
    __DIR__ . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR
);

class TestName extends PHPUnit_Framework_TestCase
{
    private function loadTests($name)
    {
        $filename = VOKATIV_TEST_DIR . $name . ".txt";

        $f = fopen($filename, 'r');
        $tests = [];

        while ($line = rtrim(fgets($f))) {
            // skip empty lines
            if (mb_strlen($line) > 0)
                $tests[] = explode(' ', $line, 2);
        }

        fclose($f);
        return $tests;
    }

    public function testBasics()
    {
        $this->assertTrue(Name::isMale('Tom'));
        $this->assertEquals('tome', Name::vokativ('Tom'));
        $this->assertEquals('tome', Name::vokativ('toM'));
        $this->assertEquals('tome', Name::vokativ('ToM'));
        $this->assertInternalType('string', Name::vokativ('Tom'));
    }

    public function testManFirstNames()
    {
        foreach (
            $this->loadTests('man_first_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, Name::vokativ($name, false, false));
            $this->assertEquals($vok, Name::vokativ($name, null, false));
            $this->assertEquals($vok, Name::vokativ($name, false));
            $this->assertEquals($vok, Name::vokativ($name));
            $this->assertTrue(Name::isMale($name));
        }
    }

    public function testManLastNames()
    {
        foreach (
            $this->loadTests('man_last_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, Name::vokativ($name, false, true));
            $this->assertEquals($vok, Name::vokativ($name, null, true));
            $this->assertEquals($vok, Name::vokativ($name, false));
            $this->assertEquals($vok, Name::vokativ($name));
            $this->assertTrue(Name::isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach (
            $this->loadTests('woman_first_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, Name::vokativ($name, true, false));
            $this->assertEquals($vok, Name::vokativ($name, null, false));
            $this->assertEquals($vok, Name::vokativ($name, true));
            $this->assertEquals($vok, Name::vokativ($name));
            $this->assertFalse(Name::isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach (
            $this->loadTests('woman_last_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, Name::vokativ($name, true, true));
            $this->assertEquals($vok, Name::vokativ($name, null, true));
            $this->assertEquals($vok, Name::vokativ($name, true));
            $this->assertEquals($vok, Name::vokativ($name));
            $this->assertFalse(Name::isMale($name));
        }
    }

    public function testCornerCases()
    {
        $this->setExpectedException('InvalidArgumentException');
        Name::vokativ(null);

        $this->setExpectedException('InvalidArgumentException');
        Name::vokativ(10);
    }
}