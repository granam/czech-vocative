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
        $this->assertEquals(Name::vokativ('Tom'), 'tome');
        $this->assertEquals(Name::vokativ('toM'), 'tome');
        $this->assertEquals(Name::vokativ('ToM'), 'tome');
        $this->assertInternalType('string', Name::vokativ('Tom'));
    }

    public function testManFirstNames()
    {
        foreach (
            $this->loadTests('man_first_name_tests') as list($name, $vok)) {

            $this->assertEquals(Name::vokativ($name, false, false), $vok);
            $this->assertEquals(Name::vokativ($name, null, false), $vok);
            $this->assertEquals(Name::vokativ($name, false), $vok);
            $this->assertEquals(Name::vokativ($name), $vok);
            $this->assertTrue(Name::isMale($name));
        }
    }

    public function testManLastNames()
    {
        foreach (
            $this->loadTests('man_last_name_tests') as list($name, $vok)) {

            $this->assertEquals(Name::vokativ($name, false, true), $vok);
            $this->assertEquals(Name::vokativ($name, null, true), $vok);
            $this->assertEquals(Name::vokativ($name, false), $vok);
            $this->assertEquals(Name::vokativ($name), $vok);
            $this->assertTrue(Name::isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach (
            $this->loadTests('woman_first_name_tests') as list($name, $vok)) {

            $this->assertEquals(Name::vokativ($name, true, false), $vok);
            $this->assertEquals(Name::vokativ($name, null, false), $vok);
            $this->assertEquals(Name::vokativ($name, true), $vok);
            $this->assertEquals(Name::vokativ($name), $vok);
            $this->assertFalse(Name::isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach (
            $this->loadTests('woman_last_name_tests') as list($name, $vok)) {

            $this->assertEquals(Name::vokativ($name, true, true), $vok);
            $this->assertEquals(Name::vokativ($name, null, true), $vok);
            $this->assertEquals(Name::vokativ($name, true), $vok);
            $this->assertEquals(Name::vokativ($name), $vok);
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