<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadsType extends LibAbstractType
{
    /**
     * Description of what this does.
     *
     * @param FormBuilderInterface $builder champs obligatoire lié a symfony
     * @param array                $options data
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'url',
            Type\HiddenType::class,
            [
                'label'    => 'Module',
                'required' => FALSE,
                'attr'     => [
                    'readonly'    => 'readonly',
                    'placeholder' => 'Module',
                ],
            ]
        );
        $builder->add(
            'min_height',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'min_height',
                'attr'     => ['min' => 0],
            ]
        );
        $builder->add(
            'max_height',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'max_height',
                'attr'     => ['min' => 0],
            ]
        );
        $builder->add(
            'min_width',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'min_width',
                'attr'     => ['min' => 0],
            ]
        );
        $builder->add(
            'max_width',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'max_width',
                'attr'     => ['min' => 0],
            ]
        );
        $builder->add(
            'image-max_width',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'max_width',
                'attr'     => ['min' => 0],
            ]
        );
        $builder->add(
            'image-max_height',
            Type\IntegerType::class,
            [
                'required' => FALSE,
                'label'    => 'max_height',
                'attr'     => ['min' => 0],
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
