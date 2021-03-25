<?php declare(strict_types=1);

namespace Granam\Tests\CzechVocative;

use Granam\CzechVocative\CzechName;
use PHPUnit\Framework\TestCase;

class CzechNameTest extends TestCase
{
    /** @var CzechName */
    private $czechName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->czechName = new CzechName();
    }

    public function testBasics()
    {
        self::assertTrue($this->czechName->isMale('Tom'));
        self::assertEquals('Tome', $this->czechName->vocative('Tom'));
        self::assertEquals('Tome', $this->czechName->vocative('toM'));
        self::assertEquals('Tome', $this->czechName->vocative('ToM'));
        self::assertIsString($this->czechName->vocative('Tom'));
    }

    public function testManFirstNames()
    {
        foreach ($this->loadTests('man_first_name_tests') as [$name, $vocative]) {
            self::assertEquals($vocative, $this->czechName->vocative($name, false, false));
            self::assertEquals($vocative, $this->czechName->vocative($name, null, false));
            self::assertEquals($vocative, $this->czechName->vocative($name, false));
            self::assertEquals($vocative, $this->czechName->vocative($name));
            self::assertTrue($this->czechName->isMale($name));
        }
    }

    private function loadTests(string $name)
    {
        $filename = __DIR__ . '/data/' . $name . '.txt';

        $f = fopen($filename, 'rb');
        $tests = [];

        while (($line = fgets($f)) !== false) {
            $line = rtrim($line);
            // skip empty lines
            if ($line !== '') {
                $tests[] = explode(' ', $line, 2);
            }
        }
        fclose($f);

        return $tests;
    }

    public function testManLastNames()
    {
        foreach ($this->loadTests('man_last_name_tests') as [$name, $vocative]) {
            self::assertEquals($vocative, $this->czechName->vocative($name, false, true));
            self::assertEquals($vocative, $this->czechName->vocative($name, null, true));
            self::assertEquals($vocative, $this->czechName->vocative($name, false));
            self::assertEquals($vocative, $this->czechName->vocative($name));
            self::assertTrue($this->czechName->isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach ($this->loadTests('woman_first_name_tests') as [$name, $vocative]) {
            self::assertEquals($vocative, $this->czechName->vocative($name, true, false));
            self::assertEquals($vocative, $this->czechName->vocative($name, null, false));
            self::assertEquals($vocative, $this->czechName->vocative($name, true));
            self::assertEquals($vocative, $this->czechName->vocative($name));
            self::assertFalse($this->czechName->isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach ($this->loadTests('woman_last_name_tests') as [$name, $vocative]) {
            self::assertEquals($vocative, $this->czechName->vocative($name, true, true));
            self::assertEquals($vocative, $this->czechName->vocative($name, null, true));
            self::assertEquals($vocative, $this->czechName->vocative($name, true));
            self::assertEquals($vocative, $this->czechName->vocative($name));
            self::assertFalse($this->czechName->isMale($name));
        }
    }

    /**
     * @test
     */
    public function I_got_vocalized_non_human_names()
    {
        self::assertSame('Androide', $this->czechName->vocative('android'));
        self::assertSame('Blackberry', $this->czechName->vocative('blackberry'));
        self::assertSame('Apple', $this->czechName->vocative('apple'));
    }

    /**
     * @test
     */
    public function I_got_vocalized_familiar_non_human_names()
    {
        self::assertSame('Androiďáku', $this->czechName->vocative('androiďák'));
        self::assertSame('Androiďačko', $this->czechName->vocative('androiďačka'));
        self::assertSame('Fitnessáku', $this->czechName->vocative('fitnessák'));
        self::assertSame('Fitnessačko', $this->czechName->vocative('fitnessačka'));
    }

    /**
     * @test
     */
    public function I_got_untouched_name_with_trailing_non_letter()
    {
        self::assertSame('nokia?!', $this->czechName->vocative('nokia?!'));
    }

    /**
     * @test
     */
    public function I_got_vocalized_name_wrapped_by_white_spaces()
    {
        self::assertSame('Siemensi', $this->czechName->vocative("\n\t  siemens \n\t   "));
    }
}
