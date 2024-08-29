<?php
namespace Velarde\PageComponentBundle;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;

class PageComponent
{
    private array $raw = [];
    private FormBuilder $formBuilder;
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

    public function getRaw(): array
    {
        return $this->raw;
    }

    public function setProcessedParameters($data = []): void
    {
        $this->processedParameters = $data;
    }

    public function getProcessedParameters()
    {
        return $this->processedParameters;
    }


    public function setFormBuilder(FormBuilder $builder): void
    {
        $this->formBuilder = $builder;
    }

    public function getFormBuilder(): FormBuilder
    {
        return $this->formBuilder;
    }


    public function getForm(): FormInterface
    {
        return $this->formBuilder->getForm();
    }

    private $rendered;
    public function setRendered($v): void
    {
        $this->rendered = $v;
    }

    public function renderView()
    {
        return $this->rendered;
    }


}
