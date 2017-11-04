<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends LibParamType
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
            'filelogin',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image background',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.login',
                ],
            ]
        );
        $builder->add(
            'login_titre',
            Type\TextType::class,
            [
                'label'    => 'Titre',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'login_soustitre',
            Type\TextType::class,
            [
                'label'    => 'Sous-titre',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'login_videobackground',
            Type\TextType::class,
            [
                'label'    => 'Video background',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'login_videomute',
            Type\ChoiceType::class,
            [
                'required'    => FALSE,
                'label'       => 'video mute',
                'placeholder' => 'video mute',
                'choices'     => [
                    'TRUE'  => 'true',
                    'FALSE' => 'false',
                ],
            ]
        );
        unset($options);
    }
}
