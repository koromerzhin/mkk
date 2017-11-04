<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlternatesType extends LibAbstractType
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
            'href',
            Type\UrlType::class,
            [
                'label'    => 'url',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'url',
                ],
            ]
        );
        $builder->add(
            'hreflang',
            Type\LanguageType::class,
            [
                'label'    => 'Nom',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Langue',
                ],
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
        $resolver->setDefaults(
            [
            'csrf_protection' => FALSE,
            ]
        );
    }
}
