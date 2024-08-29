<?php

namespace Velarde\PageComponentBundle\Service;

use Velarde\PageComponentBundle\Exception\PageComponentException;
use Velarde\PageComponentBundle\PageComponent;
use Velarde\PageComponentBundle\PageComponentBundle;

class DefaultPageComponentManager implements PageComponentManager
{
    /**
     * @param PageComponent $pageComponent
     * @param array $data
     * @return array
     * @throws PageComponentException
     */
    public function process(PageComponent $pageComponent, array $data = array()): array
    {
        $rawParameters = $pageComponent->getRaw()[PageComponentBundle::KEY_PARAMETERS];

        $processedData = array();
        foreach ($rawParameters as $key => $config) {
            if ($config["required"] && !isset($data[$key])) {
                throw PageComponentException::requiredComponentParameter($pageComponent->getId(), $key);
            }

            $processedData[$key] = $data[$key] ?? $config["default"];
        }
        $pageComponent->setProcessedParameters($processedData);

        return $processedData;
    }

}