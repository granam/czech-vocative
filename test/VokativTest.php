<?php
namespace Vokativ\Test;

use Vokativ\Name;
use PHPUnit_Framework_TestCase;

define("TEST_DIR", __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);

class TestName extends PHPUnit_Framework_TestCase
{
    private function loadTests($name)
    {
        $this->assertTrue(file_exists(TEST_DIR . $name . ".txt"));
    }

    public function testBasics()
    {

    }

    public function testManFirstNames()
    {
        return Name::vokativ('Petr');
    }

    public function testManLastNames()
    {
        return Name::vokativ('Petr');
    }

    public function testWomanFirstNames()
    {
        return Name::vokativ('Petr');
    }

    public function testWomanLastNames()
    {
        return Name::vokativ('Petr');
    }

    public function testCornerCases()
    {
        $this->setExpectedException('InvalidArgumentException');
        Name::vokativ(null);

        $this->setExpectedException('InvalidArgumentException');
        Name::vokativ(10);
    }
}