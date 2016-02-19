<?php
namespace Vokativ\Test;

use Vokativ\Name;
use PHPUnit_Framework_TestCase;

define(
"VOKATIV_TEST_DIR",
    __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
);

class TestName extends PHPUnit_Framework_TestCase
{
    /** @var Name */
    protected $_v;

    protected function loadTests($name)
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

    public function setUp()
    {
        $this->_v = new Name();
    }

    public function testBasics()
    {
        $this->assertTrue($this->_v->isMale('Tom'));
        $this->assertEquals('tome', $this->_v->vokativ('Tom'));
        $this->assertEquals('tome', $this->_v->vokativ('toM'));
        $this->assertEquals('tome', $this->_v->vokativ('ToM'));
        $this->assertInternalType('string', $this->_v->vokativ('Tom'));
    }

    public function testManFirstNames()
    {
        foreach ($this->loadTests('man_first_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vokativ($name, false, false));
            $this->assertEquals($vok, $this->_v->vokativ($name, null, false));
            $this->assertEquals($vok, $this->_v->vokativ($name, false));
            $this->assertEquals($vok, $this->_v->vokativ($name));
            $this->assertTrue($this->_v->isMale($name));
        }
    }

    public function testManLastNames()
    {
        foreach ($this->loadTests('man_last_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vokativ($name, false, true));
            $this->assertEquals($vok, $this->_v->vokativ($name, null, true));
            $this->assertEquals($vok, $this->_v->vokativ($name, false));
            $this->assertEquals($vok, $this->_v->vokativ($name));
            $this->assertTrue($this->_v->isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach ($this->loadTests('woman_first_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vokativ($name, true, false));
            $this->assertEquals($vok, $this->_v->vokativ($name, null, false));
            $this->assertEquals($vok, $this->_v->vokativ($name, true));
            $this->assertEquals($vok, $this->_v->vokativ($name));
            $this->assertFalse($this->_v->isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach ($this->loadTests('woman_last_name_tests') as $values) {
            list($name, $vok) = $values;
            $this->assertEquals($vok, $this->_v->vokativ($name, true, true));
            $this->assertEquals($vok, $this->_v->vokativ($name, null, true));
            $this->assertEquals($vok, $this->_v->vokativ($name, true));
            $this->assertEquals($vok, $this->_v->vokativ($name));
            $this->assertFalse($this->_v->isMale($name));
        }
    }

    public function testCornerCases()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->_v->vokativ(null);

        $this->setExpectedException('InvalidArgumentException');
        $this->_v->vokativ(10);
    }
}