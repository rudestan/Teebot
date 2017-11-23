<?php

declare(strict_types=1);

namespace Teebot\Configuration;

use Symfony\Component\Config\Definition\{
    Builder\TreeBuilder,
    ConfigurationInterface
};

class Config implements ConfigurationInterface
{
    public const DEFAULT_LIMIT = 1;

    public const DEFAULT_OFFSET = -1;

    private const DEFAULT_NAME = 'Teebot_test';

    private const DEFAULT_URL = 'https://api.telegram.org';

    private const DEFAULT_FILE_URL = 'https://api.telegram.org/file/bot';

    private const DEFAULT_TIMEOUT = 3;

    private const DEFAULT_METHOD = 'GET';

    private const BOT_PREFIX = 'bot';

    /**
     * Returns configuration tree builder object
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('teebot');
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('token')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('name')
                    ->defaultValue(self::DEFAULT_NAME)
                ->end()
                ->scalarNode('url')
                    ->defaultValue(self::DEFAULT_URL)
                ->end()
                ->scalarNode('file_url')
                    ->defaultValue(self::DEFAULT_FILE_URL)
                ->end()
                ->scalarNode('method')
                    ->defaultValue(self::DEFAULT_METHOD)
                ->end()
                ->scalarNode('bot_prefix')
                    ->defaultValue(self::BOT_PREFIX)
                ->end()
                ->scalarNode('timeout')
                    ->defaultValue(self::DEFAULT_TIMEOUT)
                ->end()
                ->arrayNode('options')
                    ->useAttributeAsKey('key')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('events')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('command')->end()
                            ->scalarNode('type')->end()
                            ->scalarNode('class')->end()
                            ->arrayNode('params')
                                ->prototype('array')
                                    ->useAttributeAsKey('key')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('logger')
                    ->children()
                        ->scalarNode('filename')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
