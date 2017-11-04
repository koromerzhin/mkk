<?php

namespace Mkk\AdminBundle\Form\Evenement;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LangueType extends LibAbstractType
{
    /**
     * Description of what this does.
     *
     * @param FormBuilderInterface $builder champs obligatoire lié a symfony
     * @param array                $options data de configureOptions();
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'titre',
            Type\TextType::class,
            [
                'label'    => 'Titre',
                'attr'     => ['placeholder' => 'Titre'],
                'required' => FALSE,
            ]
        );
        $builder->add(
            'description',
            WysiwygType::class,
            [
                'label'    => 'Description',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'alias',
            Type\TextType::class,
            [
                'label'    => 'Alias',
                'attr'     => ['placeholder' => 'Alias'],
                'required' => FALSE,
            ]
        );
        unset($options);
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver champs obligatoire lié a symfony
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $namespace = $this->namespace;
        $resolver->setDefaults(
            [
                'data_class'      => "{$namespace}\SiteBundle\Entity\Evenement",
                'csrf_protection' => FALSE,
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'evenement';
    }
}
