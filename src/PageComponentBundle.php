<?php

namespace Velarde\PageComponentBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Velarde\PageComponentBundle\DependencyInjection\Compiler\ComponentFactoryCompilerPass;

class PageComponentBundle extends Bundle
{
    const KEY_PARAMETERS = "parameters";
    const KEY_DEPENDENCY_MANAGER = "dependency_manager";
    const KEY_TEMPLATE = "template";
    const KEY_FORM = "form";

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ComponentFactoryCompilerPass());
    }
}
