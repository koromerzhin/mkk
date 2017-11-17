<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingsType extends LibAbstractType
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
            'module',
            Type\TextType::class,
            [
                'label'    => 'Module',
                'required' => FALSE,
                'attr'     => [
                    'readonly'    => 'readonly',
                    'placeholder' => 'Module',
                ],
            ]
        );

        $choices = [
            0   => 'Valeur par défaut',
            5   => 5,
            10  => 10,
            15  => 15,
            20  => 20,
            25  => 25,
            50  => 50,
            100 => 100,
            150 => 150,
            200 => 200,
        ];
        $builder->add(
            'val',
            Type\ChoiceType::class,
            [
                'label'    => 'Valeur',
                'required' => FALSE,
                'choices'  => $choices,
                'attr'     => [
                    'placeholder' => 'Valeur',
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
