<?php
namespace Vokativ\Test;

use Vokativ\Vokativ;
use PHPUnit_Framework_TestCase;


class TestVokativ extends PHPUnit_Framework_TestCase
{
    public function testWomanNames()
    {
        return Vokativ::vokativ('Petr');
    }
}