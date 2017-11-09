<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class ApiType extends LibParamType
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
            'disqus_url',
            Type\TextType::class,
            [
                'label'    => 'url',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => '//machin.disqus.com/',
                ],
            ]
        );
        $builder->add(
            'google_id',
            Type\TextType::class,
            [
                'label'    => 'App ID',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'google_secret',
            Type\TextType::class,
            [
                'label'    => 'App Secret',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'facebook_key',
            Type\TextType::class,
            [
                'label'    => 'App ID',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'facebook_secret',
            Type\TextType::class,
            [
                'label'    => 'App Secret',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'twitter_key',
            Type\TextType::class,
            [
                'label'    => 'API Key',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'twitter_secret',
            Type\TextType::class,
            [
                'label'    => 'API Secret',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'bug_url',
            Type\UrlType::class,
            [
                'label'    => 'url',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'bug_project',
            Type\TextType::class,
            [
                'label'    => 'Identifiant du projet',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'bug_code',
            Type\TextType::class,
            [
                'label'    => "Clé d'accès API",
                'required' => FALSE,
            ]
        );
        $builder->add(
            'recaptcha_clef',
            Type\TextType::class,
            [
                'label'    => 'Clé du site',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'recaptcha_secret',
            Type\TextType::class,
            [
                'label'    => 'Clé secrète',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'piwik_url',
            Type\TextType::class,
            [
                'label'    => 'URL (sans http://)',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'piwik_id',
            Type\TextType::class,
            [
                'label'    => 'ID',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'google_analytic',
            Type\TextType::class,
            [
                'label'    => 'Analytics',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'google_keyapi',
            Type\TextType::class,
            [
                'label'    => 'Key API',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'google_webmastertool',
            Type\TextType::class,
            [
                'label'    => 'Webmaster Tool',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'geonames',
            Type\TextType::class,
            [
                'label'    => 'Code geonames',
                'required' => FALSE,
            ]
        );
        unset($options);
    }
}
