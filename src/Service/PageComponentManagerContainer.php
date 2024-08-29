<?php

namespace Velarde\PageComponentBundle\Service;

use Velarde\PageComponentBundle\Exception\PageComponentException;

class PageComponentManagerContainer
{
    private array $managers = [];

    public function __construct()
    {
        $this->managers = [];
    }

    public function inject($id, PageComponentManager $manager): void
    {
        $this->managers[$id] = $manager;
    }

    /**
     * @param $id
     * @return PageComponentManager
     *
     * @throws PageComponentException
     */
    public function get($id): PageComponentManager
    {
        if (!array_key_exists($id, $this->managers)) {
            throw PageComponentException::loadedUnknownManager($id);
        }

        return $this->managers[$id];
    }
}