<?php
namespace Velarde\PageComponentBundle\Twig;

use Velarde\PageComponentBundle\Service\PageComponentFactory;

class PageComponentTwigExtension extends \Twig_Extension
{
    /**
     * @var PageComponentFactory
     */
    private $factory;

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('render_component', [$this, 'renderComponent']),
        ];
    }

    public function  setComponentFactory(PageComponentFactory $v)
    {
        $this->factory = $v;
    }

    public function renderComponent($componentId, $data)
    {
        $component = $this->factory->load($componentId, $data, ["rendered" => true, "form" => false]);

        return $component->renderView();
    }
}
