<?php

namespace Mkk\AdminBundle\Form;

use Mkk\AdminBundle\Form\Collection\AdressesType;
use Mkk\AdminBundle\Form\Collection\EmailsType;
use Mkk\AdminBundle\Form\Collection\LiensType;
use Mkk\AdminBundle\Form\Collection\TelephonesType;
use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends LibAbstractType
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
            'fileavatar',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image Profil',
                'attr'     => [
                    'data-upload' => 'admin.profil.upload.avatar',
                ],
            ]
        );
        $builder->add(
            'nom',
            Type\TextType::class,
            [
                 'label'    => 'Nom',
                 'required' => FALSE,
             ]
        );
        $civilite = [];
        foreach ($this->params['civilite'] as $data) {
            $code           = $data['code'];
            $nom            = $data['nom'];
            $civilite[$nom] = $code;
        }

        $builder->add(
            'civilite',
            Type\ChoiceType::class,
            [
                'expanded' => TRUE,
                'label'    => 'Civilité',
                'choices'  => $civilite,
            ]
        );
        $builder->add(
            'adresses',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => AdressesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Adresses',
            ]
        );
        $builder->add(
            'liens',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => liensType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Liens',
            ]
        );
        $builder->add(
            'emails',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => EmailsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Emails',
            ]
        );
        $builder->add(
            'telephones',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TelephonesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Téléphones',
            ]
        );
        $builder->add(
            'prenom',
            Type\TextType::class,
            [
                'label'    => 'Prénom',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'naissance',
            Type\TextType::class,
            [
                'label'    => 'Date de naissance',
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'DateNaissance',
                    'placeholder' => 'dd/mm/YYYY',
                    'data-max'    => date('d/m/Y'),
                ],
            ]
        );
        $builder->add(
            'username',
            Type\TextType::class,
            [
                'required' => FALSE,
                 'label'   => 'Identifiant',
             ]
        );
        $builder->add(
            'plainPassword',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Mot de passe',
            ]
        );
        $choices      = [];
        $languageName = $this->languageBundle->getLanguageNames($this->locale);
        foreach ($this->params['languesite'] as $langue) {
            $name           = $languageName[$langue];
            $choices[$name] = $langue;
        }

        $builder->add(
            'pays',
            Type\ChoiceType::class,
            [
                'choices' => $choices,
                'label'   => 'Langue utilisée',
            ]
        );
        $builder->add(
            'langue',
            Type\ChoiceType::class,
            [
                'choices' => $choices,
                'label'   => 'Langue du site',
            ]
        );
        $builder->add(
            'contactsms',
            OuiNonType::class,
            [
                'label' => 'Communication par SMS',
                'attr'  => ['data-rel' => 'CheckboxSmsContact'],
            ]
        );
        $builder->add(
            'contactemail',
            OuiNonType::class,
            [
                'label' => 'Communication par Email',
                'attr'  => ['data-rel' => 'CheckboxEmailContact'],
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
        $namespace = $this->namespace;
        $resolver->setDefaults(
            [
                'data_class' => "{$namespace}\SiteBundle\Entity\User",
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
        return 'moncompte';
    }
}
