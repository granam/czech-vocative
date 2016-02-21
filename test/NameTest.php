<?php
namespace Vocative\Test;

use Vocative\Name;

define(
"VOCATIVE_TEST_DIR",
    __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
);

class TestName extends \PHPUnit_Framework_TestCase
{
    /** @var Name */
    protected $_v;

    protected function loadTests($name)
    {
        $filename = VOCATIVE_TEST_DIR . $name . ".txt";

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

    public function setUp()
    {
        $this->_v = new Name();
    }

    public function testBasics()
    {
        $this->assertTrue($this->_v->isMale('Tom'));
        $this->assertEquals('Tome', $this->_v->vocative('Tom'));
        $this->assertEquals('Tome', $this->_v->vocative('toM'));
        $this->assertEquals('Tome', $this->_v->vocative('ToM'));
        $this->assertInternalType('string', $this->_v->vocative('Tom'));
    }

    public function testManFirstNames()
    {
        foreach ($this->loadTests('man_first_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vocative($name, false, false));
            $this->assertEquals($vok, $this->_v->vocative($name, null, false));
            $this->assertEquals($vok, $this->_v->vocative($name, false));
            $this->assertEquals($vok, $this->_v->vocative($name));
            $this->assertTrue($this->_v->isMale($name));
        }
    }

    public function testManLastNames()
    {
        foreach ($this->loadTests('man_last_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vocative($name, false, true));
            $this->assertEquals($vok, $this->_v->vocative($name, null, true));
            $this->assertEquals($vok, $this->_v->vocative($name, false));
            $this->assertEquals($vok, $this->_v->vocative($name));
            $this->assertTrue($this->_v->isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach ($this->loadTests('woman_first_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vocative($name, true, false));
            $this->assertEquals($vok, $this->_v->vocative($name, null, false));
            $this->assertEquals($vok, $this->_v->vocative($name, true));
            $this->assertEquals($vok, $this->_v->vocative($name));
            $this->assertFalse($this->_v->isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach ($this->loadTests('woman_last_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vocative($name, true, true));
            $this->assertEquals($vok, $this->_v->vocative($name, null, true));
            $this->assertEquals($vok, $this->_v->vocative($name, true));
            $this->assertEquals($vok, $this->_v->vocative($name));
            $this->assertFalse($this->_v->isMale($name));
        }
    }
}