<?php

namespace TeebotUnitTest\Api\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Teebot\Configuration\Config;
use Symfony\Component\Config\Definition\ArrayNode;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    protected $sut;

    /**
     * @var array
     */
    protected $expectedConfigKeys = [
        'bot_prefix',
        'events',
        'file_url',
        'logger',
        'method',
        'name',
        'options',
        'timeout',
        'token',
        'url',
    ];

    /**
     * Sets up a test
     */
    protected function setUp()
    {
        $this->sut = new Config();
    }

    /**
     * Test that getConfigurationTreeBuilder returns correct configuration tree
     */
    public function testGetConfigurationTreeBuilder()
    {
        $treeBuilder = $this->sut->getConfigTreeBuilder();

        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);

        /** @var ArrayNode $tree */
        $tree = $treeBuilder->buildTree();

        $configKeys = array_keys($tree->getChildren());
        sort($configKeys);
        sort($this->expectedConfigKeys);

        $this->assertSame($this->expectedConfigKeys, $configKeys);

    }
}
