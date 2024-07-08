<?php
namespace Velarde\PageComponentBundle;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Velarde\PageComponentBundle\Service\PageComponentManager;

class PageComponent
{
    private $raw = [];

    /**
     * @var FormBuilder
     */
    private $formBuilder;

    private $id;

    private $processedParameters;

    public function __construct($id, array $raw=[])
    {
        $this->id = $id;
        $this->raw = $raw;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function setProcessedParameters($data = [])
    {
        $this->processedParameters = $data;
    }

    public function getProcessedParameters()
    {
        return $this->processedParameters;
    }


    public function setFormBuilder(FormBuilder $builder)
    {
        $this->formBuilder = $builder;
    }

    public function getFormBuilder()
    {
        return $this->formBuilder;
    }


    public function getForm()
    {
        return $this->formBuilder->getForm();
    }

    private $rendered;
    public function setRendered($v)
    {
        $this->rendered = $v;
    }

    public function renderView()
    {
        return $this->rendered;
    }


}
