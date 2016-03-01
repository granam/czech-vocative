<?php
namespace CzechVocative\Test;

use CzechVocative\CzechName;

define(
"VOCATIVE_TEST_DIR",
    __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
);

class CzechNameTest extends \PHPUnit_Framework_TestCase
{
    /** @var CzechName */
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
        $this->_v = new CzechName();
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

    /**
     * @test
     */
    public function I_got_vocalized_non_human_names()
    {
        $this->assertSame('Androide', $this->_v->vocative('android'));
        $this->assertSame('Blackberry', $this->_v->vocative('blackberry'));
        $this->assertSame('Apple', $this->_v->vocative('apple'));
    }

    /**
     * @test
     */
    public function I_got_untouched_name_with_trailing_non_letter()
    {
        $this->assertSame('nokia?!', $this->_v->vocative('nokia?!'));
    }

    /**
     * @test
     */
    public function I_got_vocalized_name_wrapped_by_white_spaces()
    {
        $this->assertSame('Siemensi', $this->_v->vocative("\n\t  siemens \n\t   "));
    }
}