<?php
namespace Velarde\PageComponentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ComponentFactoryCompilerPass implements CompilerPassInterface
{

    /**
     * Load dependencies
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has("page_component.manager_container")) {
            return;
        }

        $definition = $container->findDefinition('page_component.manager_container');
        $taggedManagers = $container->findTaggedServiceIds('page_component.manager');

        foreach ($taggedManagers as $id => $tags) {
            $definition->addMethodCall('inject', array($id, new Reference($id)));
        }

        




    }
}

