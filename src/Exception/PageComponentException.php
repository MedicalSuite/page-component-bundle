<?php
namespace Velarde\PageComponentBundle\Exception;

class PageComponentException extends \Exception
{
    static public function loadedUnknownComponent($component)
    {
        return new PageComponentException("Failed to load unknown component: {$component}.");
    }

    static public function loadedUnknownManager($id)
    {
        return new PageComponentException("Failed to load non-existent component manager: {$id}.");
    }

    static public function requiredComponentParameter($id, $parameter)
    {
        return new PageComponentException("Required parameter: {$parameter} for component: {$id}.");
    }
}
