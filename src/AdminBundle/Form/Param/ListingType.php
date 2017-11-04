<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\ListingsType;
use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class ListingType extends LibParamType
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
            'submit',
            Type\SubmitType::class
        );
        $builder->add(
            'longueurliste',
            Type\ChoiceType::class,
            [
                'label'   => 'Admin',
                'choices' => [
                    5   => 5,
                    10  => 10,
                    15  => 15,
                    20  => 20,
                    25  => 25,
                    50  => 50,
                    100 => 100,
                    150 => 150,
                    200 => 200,
                ],
            ]
        );
        $builder->add(
            'publicliste',
            Type\IntegerType::class,
            [
                'label' => 'Publique',
                'attr'  => ['min' => 1],
            ]
        );
        $builder->add(
            'module_listing',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => ListingsType::class,
                'allow_add'    => FALSE,
                'delete_empty' => TRUE,
                'allow_delete' => FALSE,
                'label'        => 'Par modules',
            ]
        );
        unset($options);
    }
}
