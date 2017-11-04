<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LiensType extends LibAbstractType
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
            'nom',
            Type\TextType::class,
            [
                'label'    => 'Nom',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Nom',
                ],
            ]
        );
        $builder->add(
            'adresse',
            Type\UrlType::class,
            [
                'label'    => 'Url',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'http://',
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Lien",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
