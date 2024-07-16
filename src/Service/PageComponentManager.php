<?php

namespace Velarde\PageComponentBundle\Service;

use Velarde\PageComponentBundle\PageComponent;

interface PageComponentManager
{
    /**
     * @param PageComponent $component
     * @param array $data
     * @return
     */
    public function process(PageComponent $component, array $data=[]);
}