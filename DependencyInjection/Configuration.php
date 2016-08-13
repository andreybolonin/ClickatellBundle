<?php

namespace Archer\ClickatellBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('archer_clickatell');

        $rootNode->children()
                ->scalarNode('user')->isRequired()->end()
                ->scalarNode('password')->isRequired()->end()
                ->scalarNode('api_id')->isRequired()->end()
                ->scalarNode('message_class')->isRequired()->end()
                ->end();

        $this->addReplyMessageSection($rootNode);
        $this->addSendMessageSection($rootNode);

        return $treeBuilder;
    }

    private function addReplyMessageSection(ArrayNodeDefinition $node)
    {
        $node
                ->children()
                    ->arrayNode('reply_message')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('type')->defaultValue('clickatell_reply_message')->end()
                                    ->scalarNode('name')->defaultValue('clickatell_reply_message')->end()
                                    ->booleanNode('csrf_protection')->defaultTrue()->end()
                                    ->arrayNode('validation_groups')
                                        ->prototype('scalar')->end()
                                        ->defaultValue(array('replyMessage'))
                                    ->end()
                                ->end()
                        ->end()
                    ->end()
                ->end();
    }

    private function addSendMessageSection(ArrayNodeDefinition $node)
    {
        $node
                ->children()
                    ->arrayNode('send_message')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('type')->defaultValue('clickatell_send_message')->end()
                                    ->scalarNode('name')->defaultValue('clickatell_send_message')->end()
                                    ->booleanNode('csrf_protection')->defaultFalse()->end()
                                    ->arrayNode('validation_groups')
                                        ->prototype('scalar')->end()
                                        ->defaultValue(array('sendMessage'))
                                    ->end()
                                ->end()
                        ->end()
                    ->end()
                ->end();
    }
}
