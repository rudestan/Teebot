<?php

use Teebot\Config;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    protected function getConfigMock()
    {
        /** @var Config $configMock */
        return $this->getMockBuilder('Teebot\Config')
            ->disableOriginalConstructor()
            ->getMock();
    }
}