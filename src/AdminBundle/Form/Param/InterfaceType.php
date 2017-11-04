<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class InterfaceType extends LibParamType
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
            'cookiebanner_actif',
            OuiNonType::class,
            [
                'label' => 'Actif',
            ]
        );
        $builder->add(
            'cookiebanner_position',
            Type\ChoiceType::class,
            [
                'required'    => FALSE,
                'label'       => 'position',
                'placeholder' => 'position',
                'choices'     => [
                    'top'    => 'top',
                    'bottom' => 'bottom',
                ],
            ]
        );
        $builder->add(
            'cookiebanner_close-text',
            Type\TextType::class,
            [
                'label'    => 'close-text',
                'required' => FALSE,
                'attr'     => [
                    'class' => 'colorpicker',
                ],
            ]
        );
        $builder->add(
            'cookiebanner_effect',
            Type\TextType::class,
            [
                'label'    => 'effect',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'cookiebanner_mask-opacity',
            Type\TextType::class,
            [
                'label'    => 'mask-opacity',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'cookiebanner_mask-background',
            Type\TextType::class,
            [
                'label'    => 'mask-background',
                'required' => FALSE,
                'attr'     => [
                    'class' => 'colorpicker',
                ],
            ]
        );
        $builder->add(
            'modal_keyboard',
            OuiNonType::class,
            [
                'label' => "Lorsque l'on clique sur la toile de fond",
            ]
        );
        $builder->add(
            'modal_backdrop',
            OuiNonType::class,
            [
                'label' => "Lorsque la touche d'échappement est pressé",
            ]
        );
        unset($options);
    }
}
