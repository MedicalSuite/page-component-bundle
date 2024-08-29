<?php
namespace Velarde\PageComponentBundle\Twig;

use Velarde\PageComponentBundle\Exception\PageComponentException;
use Velarde\PageComponentBundle\Service\PageComponentFactory;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class PageComponentTwigExtension extends AbstractExtension
{
    private PageComponentFactory $factory;

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_component', [$this, 'renderComponent']),
        ];
    }

    public function  setComponentFactory(PageComponentFactory $v): void
    {
        $this->factory = $v;
    }

    /**
     * @throws PageComponentException
     */
    public function renderComponent($componentId, $data)
    {
        $component = $this->factory->load($componentId, $data, ["rendered" => true, "form" => false]);

        return $component->renderView();
    }
}
