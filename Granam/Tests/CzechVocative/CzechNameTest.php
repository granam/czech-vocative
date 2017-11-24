<?php
namespace CzechVocative\Tests;

use Granam\CzechVocative\CzechName;
use PHPUnit\Framework\TestCase;

class CzechNameTest extends TestCase
{
    /** @var CzechName */
    private $_v;

    protected function setUp()
    {
        $this->_v = new CzechName();
    }

    public function testBasics()
    {
        self::assertTrue($this->_v->isMale('Tom'));
        self::assertEquals('Tome', $this->_v->vocative('Tom'));
        self::assertEquals('Tome', $this->_v->vocative('toM'));
        self::assertEquals('Tome', $this->_v->vocative('ToM'));
        self::assertInternalType('string', $this->_v->vocative('Tom'));
    }

    public function testManFirstNames()
    {
        foreach ($this->loadTests('man_first_name_tests') as list($name, $vocative)) {
            self::assertEquals($vocative, $this->_v->vocative($name, false, false));
            self::assertEquals($vocative, $this->_v->vocative($name, null, false));
            self::assertEquals($vocative, $this->_v->vocative($name, false));
            self::assertEquals($vocative, $this->_v->vocative($name));
            self::assertTrue($this->_v->isMale($name));
        }
    }

    private function loadTests($name)
    {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $name . '.txt';

        $f = \fopen($filename, 'rb');
        $tests = [];

        while ($line = \rtrim(fgets($f))) {
            // skip empty lines
            if (\mb_strlen($line) > 0) {
                $tests[] = \explode(' ', $line, 2);
            }
        }

        \fclose($f);

        return $tests;
    }

    public function testManLastNames()
    {
        foreach ($this->loadTests('man_last_name_tests') as list($name, $vocative)) {
            self::assertEquals($vocative, $this->_v->vocative($name, false, true));
            self::assertEquals($vocative, $this->_v->vocative($name, null, true));
            self::assertEquals($vocative, $this->_v->vocative($name, false));
            self::assertEquals($vocative, $this->_v->vocative($name));
            self::assertTrue($this->_v->isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach ($this->loadTests('woman_first_name_tests') as list($name, $vocative)) {
            self::assertEquals($vocative, $this->_v->vocative($name, true, false));
            self::assertEquals($vocative, $this->_v->vocative($name, null, false));
            self::assertEquals($vocative, $this->_v->vocative($name, true));
            self::assertEquals($vocative, $this->_v->vocative($name));
            self::assertFalse($this->_v->isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach ($this->loadTests('woman_last_name_tests') as list($name, $vocative)) {
            self::assertEquals($vocative, $this->_v->vocative($name, true, true));
            self::assertEquals($vocative, $this->_v->vocative($name, null, true));
            self::assertEquals($vocative, $this->_v->vocative($name, true));
            self::assertEquals($vocative, $this->_v->vocative($name));
            self::assertFalse($this->_v->isMale($name));
        }
    }

    /**
     * @test
     */
    public function I_got_vocalized_non_human_names()
    {
        self::assertSame('Androide', $this->_v->vocative('android'));
        self::assertSame('Blackberry', $this->_v->vocative('blackberry'));
        self::assertSame('Apple', $this->_v->vocative('apple'));
    }

    /**
     * @test
     */
    public function I_got_vocalized_familiar_non_human_names()
    {
        self::assertSame('Androiďáku', $this->_v->vocative('androiďák'));
        self::assertSame('Androiďačko', $this->_v->vocative('androiďačka'));
        self::assertSame('Fitnessáku', $this->_v->vocative('fitnessák'));
        self::assertSame('Fitnessačko', $this->_v->vocative('fitnessačka'));
    }

    /**
     * @test
     */
    public function I_got_untouched_name_with_trailing_non_letter()
    {
        self::assertSame('nokia?!', $this->_v->vocative('nokia?!'));
    }

    /**
     * @test
     */
    public function I_got_vocalized_name_wrapped_by_white_spaces()
    {
        self::assertSame('Siemensi', $this->_v->vocative("\n\t  siemens \n\t   "));
    }
}