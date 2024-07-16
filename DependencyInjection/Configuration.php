<?php

namespace Velarde\PageComponentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Velarde\PageComponentBundle\PageComponent;
use Velarde\PageComponentBundle\PageComponentBundle;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('page_component');
        $rootNode = $treeBuilder->getRootNode();

        // add components configuration
        $this->buildComponents($rootNode);


        return $treeBuilder;
    }

    private function buildComponents(ArrayNodeDefinition $node)
    {
        $node->children()

            ->arrayNode("components")
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey("id")
                ->prototype("array")
                    ->children()
                        ->scalarNode(PageComponentBundle::KEY_DEPENDENCY_MANAGER)->defaultNull()->end()
                        ->scalarNode(PageComponentBundle::KEY_TEMPLATE)->isRequired()->end()
                        ->scalarNode(PageComponentBundle::KEY_FORM)->defaultNull()->end()
                        ->arrayNode(PageComponentBundle::KEY_PARAMETERS)
                            ->useAttributeAsKey("id")
                            ->prototype("array")
                                ->children()
                                    ->booleanNode("required")->defaultFalse()->end()
                                    ->scalarNode("default")->defaultNull()->end()
                                    ->scalarNode("form")->defaultNull()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
