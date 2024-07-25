<?php
namespace Velarde\PageComponentBundle\Twig;

use Velarde\PageComponentBundle\Service\PageComponentFactory;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class PageComponentTwigExtension extends AbstractExtension
{
    /**
     * @var PageComponentFactory
     */
    private $factory;

    public function getFunctions()
    {
        return [
            new TwigFunction('render_component', [$this, 'renderComponent']),
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
