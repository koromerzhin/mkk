<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\AlternatesType;
use Mkk\AdminBundle\Lib\LibParamType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class SiteType extends LibParamType
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
            'url',
            Type\UrlType::class,
            [
                'label'                => 'Url du site Internet',
                                'attr' => [
                                    'placeholder' => 'http://www.example.com',
                                ],
            ]
        );
        $builder->add(
            'alternate',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => AlternatesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Url alternative',
            ]
        );
        $builder->add(
            'meta_theme_color',
            Type\TextType::class,
            [
                'label' => 'Couleur barre navigateur',
                'attr'  => [
                    'class' => 'colorpicker',
                ],
            ]
        );
        $builder->add(
            'seo_titre',
            OuiNonType::class,
            [
                'label' => 'Titre à gauche',
            ]
        );
        $builder->add(
            'langueprincipal',
            Type\LanguageType::class,
            [
                'label'    => 'Langue principal',
                'required' => TRUE,
            ]
        );
        $builder->add(
            'languesite',
            Type\LanguageType::class,
            [
                'label'    => 'Langue(s) disponible',
                'required' => TRUE,
                'multiple' => TRUE,
            ]
        );
        $builder->add(
            'meta_titre',
            Type\TextType::class,
            [
                'label' => 'meta Titre',
            ]
        );
        $builder->add(
            'meta_description',
            Type\TextType::class,
            [
                'label' => 'meta Description',
            ]
        );
        $builder->add(
            'meta_keywords',
            Type\TextType::class,
            [
                'label' => 'meta Mots clefs',
            ]
        );
        $builder->add(
            'signature',
            Type\TextareaType::class,
            [
                'label'    => 'Signature',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'crontab',
            Type\TextareaType::class,
            [
                'label'    => ' ',
                'required' => FALSE,
                'attr'     => [
                    'rows' => 10,
                ],
            ]
        );
        $builder->add(
            'droitlegaux',
            Type\TextareaType::class,
            [
                'label'    => 'Droits légaux',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'desactivation_etat',
            OuiNonType::class,
            [
                'label' => 'Etat',
            ]
        );
        $builder->add(
            'desactivation_raison',
            Type\TextareaType::class,
            [
                'label'    => 'Raison',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'emailsite',
            Type\EmailType::class,
            [
                'label' => 'Email principal',
            ]
        );
        $builder->add(
            'payssite',
            Type\CountryType::class,
            [
                'label' => 'Pays',
            ]
        );
        $builder->add(
            'emailreply',
            Type\EmailType::class,
            [
                'required' => FALSE,
                'label'    => 'Email de réponse',
            ]
        );
        unset($options);
    }
}
