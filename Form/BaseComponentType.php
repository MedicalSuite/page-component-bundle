<?php
namespace Velarde\PageComponentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Velarde\PageComponentBundle\PageComponent;
use Velarde\PageComponentBundle\PageComponentBundle;

class BaseComponentType extends AbstractType
{
    protected $component;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildComponentForm($builder, $options);
    }

    protected function buildComponentForm(FormBuilderInterface $builder, array $options)
    {
        $pageComponent = $options["page_component"];
        if (!$pageComponent instanceof PageComponent){
            return;
        }

        $parameters = $pageComponent->getRaw()[PageComponentBundle::KEY_PARAMETERS];

        foreach ($parameters as $id => $details) {
            $formType = $details["form"] == null ? TextType::class : $details["form"];
            $builder->add($id, $formType);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "page_component" => null
        ]);
    }
}