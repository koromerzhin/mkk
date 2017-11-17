<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class RobotstxtType extends LibParamType
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
            'robotstxt',
            Type\TextareaType::class,
            [
                'label'    => 'Robots.txt',
                'required' => FALSE,
                'attr'     => [
                    'rows' => 10,
                ],
            ]
        );
        unset($options);
    }
}
