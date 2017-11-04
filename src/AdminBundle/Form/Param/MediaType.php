<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class MediaType extends LibParamType
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
            'filelogobackend',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Logo',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.logobackend',
                ],
            ]
        );
        $builder->add(
            'fileavatar',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Avatar',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.avatar',
                ],
            ]
        );
        $builder->add(
            'filegooglemaps',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Pointer Google Maps',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.googlemaps',
                ],
            ]
        );
        $builder->add(
            'filelogo',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Logo backend',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.logo',
                ],
            ]
        );
        $builder->add(
            'filefavicon',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Favicon',
                'attr'     => [
                    'data-upload' => 'admin.param.upload.favicon',
                ],
            ]
        );
        unset($options);
    }
}
