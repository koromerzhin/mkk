<?php

namespace Mkk\AdminBundle\Form\Noteinterne;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\OuiNonType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardType extends LibAbstractType
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
            'envoyer',
            Type\SubmitType::class
        );
        $builder->add(
            'titre',
            Type\TextType::class,
            [
                'required' => TRUE,
                'label'    => 'Titre',
            ]
        );
        $builder->add(
            'lien',
            Type\UrlType::class,
            [
                'required' => FALSE,
                'label'    => 'Lien pour en savoir plus',
            ]
        );
        $builder->add(
            'contenu',
            WysiwygType::class,
            [
                'label'    => 'Contenu',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'publier',
            OuiNonType::class,
            [
                'label' => 'Publier',
            ]
        );
        $builder->add(
            'tous',
            OuiNonType::class,
            [
                'label'  => 'Envoyer à tous',
                'mapped' => FALSE,
            ]
        );
        $builder->add(
            'groupes',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Envoyer à ces groupes',
                'mapped'   => FALSE,
                'attr'     => [
                    'data-url'      => 'admin.noteinterne.search.group',
                    'data-multiple' => TRUE,
                    'disabled'      => 'disabled',
                ],
            ]
        );
        $builder->add(
            'entreprises',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Envoyer à ces entreprises',
                'mapped'   => FALSE,
                'attr'     => [
                    'data-url'      => 'admin.noteinterne.search.etablissement',
                    'data-multiple' => TRUE,
                    'disabled'      => 'disabled',
                ],
            ]
        );
        $builder->add(
            'users',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Envoyer à ces personnes',
                'mapped'   => FALSE,
                'attr'     => [
                    'data-url'      => 'admin.noteinterne.search.user',
                    'data-multiple' => TRUE,
                    'disabled'      => 'disabled',
                ],
            ]
        );
        $md5 = md5(uniqid());
        $builder->add(
            'datedebut',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Du ',
                'attr'     => [
                    'placeholder'     => 'Date de début',
                    'data-md5'        => $md5,
                    'class'           => 'datepicker',
                    'data-datepicker' => 'min',
                ],
            ]
        );
        $builder->add(
            'datefin',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => ' au ',
                'attr'     => [
                    'placeholder'     => 'Date de fin',
                    'data-md5'        => $md5,
                    'class'           => 'datepicker',
                    'data-datepicker' => 'max',
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
                'datedebut' => '',
                'datefin'   => '',
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'noteinterne';
    }
}
