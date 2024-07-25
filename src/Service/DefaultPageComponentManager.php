<?php

namespace Velarde\PageComponentBundle\Service;

use Velarde\PageComponentBundle\Exception\PageComponentException;
use Velarde\PageComponentBundle\PageComponent;
use Velarde\PageComponentBundle\PageComponentBundle;

class DefaultPageComponentManager implements PageComponentManager
{
    public function process(PageComponent $pageComponent, array $data = array())
    {
        $rawParameters = $pageComponent->getRaw()[PageComponentBundle::KEY_PARAMETERS];

        $processedData = array();
        foreach ($rawParameters as $key => $config) {
            if ($config["required"] && !isset($data[$key])) {
                throw PageComponentException::requiredComponentParameter($pageComponent->getId(), $key);
            }

            $processedData[$key] = isset($data[$key]) ? $data[$key] : $config["default"];
        }
        $pageComponent->setProcessedParameters($processedData);

        return $processedData;
    }

}