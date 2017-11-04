<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends LibParamType
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
            'blogmettre_avant',
            Type\ChoiceType::class,
            [
                'label'   => 'Mettre en avant',
                'choices' => [
                    'Activé'     => 1,
                    'Desactivé'  => 0,
                ],
            ]
        );
        $builder->add(
            'blogcacherpardefautredacteur',
            Type\ChoiceType::class,
            [
                'label'   => 'Cacher par défaut le rédacteur',
                'choices' => [
                    'Activé'     => 1,
                    'Desactivé'  => 0,
                ],
            ]
        );
        $builder->add(
            'blogmettre_accueil',
            Type\ChoiceType::class,
            [
                'label'   => "Mettre à l'accueil",
                'choices' => [
                    'Activé'     => 1,
                    'Desactivé'  => 0,
                ],
            ]
        );
        unset($options);
    }
}
