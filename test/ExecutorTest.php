<?php
use Teebot\Config;
use Teebot\Request;

class ExecutorTest extends PHPUnit_Framework_TestCase
{
    protected $sut;

    public function setUp()
    {
        $config = new Config();
        $this->sut = new Request($config);
    }

    public function testExampleAssertion()
    {
        $k = 1;
        $t = 1;
        $this->assertSame($k, $t);
    }

}