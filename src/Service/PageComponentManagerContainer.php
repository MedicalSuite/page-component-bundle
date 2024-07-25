<?php

namespace Velarde\PageComponentBundle\Service;

use Velarde\PageComponentBundle\Exception\PageComponentException;

class PageComponentManagerContainer
{
    private $managers = [];
    public function __construct()
    {
        $this->managers = [];
    }

    public function inject($id,  PageComponentManager $manager)
    {
        $this->managers[$id] = $manager;
    }

    /**
     * @param $id
     * @return PageComponentManager
     *
     * @throws PageComponentException
     */
    public function get($id)
    {
        if (!array_key_exists($id, $this->managers)) {
            throw PageComponentException::loadedUnknownManager($id);
        }

        return $this->managers[$id];

    }

}