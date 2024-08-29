<?php

namespace Velarde\PageComponentBundle\Service;

use Symfony\Component\Form\FormFactory;
use Twig\Environment;
use Velarde\PageComponentBundle\Exception\PageComponentException;
use Velarde\PageComponentBundle\Form\BaseComponentType;
use Velarde\PageComponentBundle\PageComponent;
use Velarde\PageComponentBundle\PageComponentBundle;

class PageComponentFactory
{
    const LOAD_WITH_FORM_OPTION = "with_form";
    const LOAD_WITH_RENDERED_VIEW = "rendered";

    private $rawComponents;

    private PageComponentManagerContainer $managerContainer;

    private FormFactory $formFactory;
    private Environment $twig;

    public function __construct($components)
    {
        $this->rawComponents = $components;

    }

    public function setManagerContainer(PageComponentManagerContainer $container): void
    {
        $this->managerContainer = $container;
    }

    public function setFormFactory($factory): void
    {
        $this->formFactory = $factory;
    }

    public function setTwig(Environment $v): void
    {
        $this->twig = $v;
    }


    /**
     * @param $componentId
     * @param array $data
     * @param array $options
     * @return PageComponent
     * @throws PageComponentException
     */
    public function load($componentId, array $data = [], array $options=array()): PageComponent
    {
        $defaultOptions = [
            self::LOAD_WITH_FORM_OPTION => true,
            self::LOAD_WITH_RENDERED_VIEW => false
        ];
        $options = array_merge($defaultOptions, $options);

        if (!isset($this->rawComponents[$componentId])) {
            throw PageComponentException::loadedUnknownComponent($componentId);
        }

        $rawConfig = $this->rawComponents[$componentId];

        $managerId = null == $rawConfig[PageComponentBundle::KEY_DEPENDENCY_MANAGER] ? "page_component.default_manager" : $rawConfig[PageComponentBundle::KEY_DEPENDENCY_MANAGER];
        $dependencyManager = $this->managerContainer->get($managerId);


        $pageComponent = new PageComponent($componentId, $rawConfig);

        // process the component data
        $dependencyManager->process($pageComponent, $data);

        // with_form option passed, build the component form
        if ($options[self::LOAD_WITH_FORM_OPTION]) {
            $this->buildComponentForm($pageComponent);
        }

        // rendered option passed, build the component view
        if ($options[self::LOAD_WITH_RENDERED_VIEW]) {
            $this->buildComponentView($pageComponent);
        }

        return $pageComponent;
    }

    private function buildComponentForm(PageComponent $component): void
    {
        $componentFormClass = $component->getRaw()[PageComponentBundle::KEY_FORM];
        $formOptions = [];

        if (is_null($componentFormClass)) {
            $componentFormClass = BaseComponentType::class;
            $formOptions["page_component"] = $component;
        }
        elseif (is_subclass_of($componentFormClass, BaseComponentType::class)) {
            // we only pass page_component option for sub-classes of BaseComponentType
            $formOptions["page_component"] = $component;
        }

        $builder = $this->formFactory->createNamedBuilder($component->getId(), $componentFormClass, $component->getProcessedParameters(), $formOptions);

        $component->setFormBuilder($builder);
    }

    private function buildComponentView(PageComponent $component): void
    {
        $template = $component->getRaw()[PageComponentBundle::KEY_TEMPLATE];
        $component->setRendered($this->twig->render($template, $component->getProcessedParameters()));
    }


}
