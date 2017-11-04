<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends LibAbstractType
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
            'nom',
            Type\TextType::class,
            [
                'label' => 'Nom',
                'attr'  => [
                    'placeholder' => 'Nom',
                ],
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
            'prenom',
            Type\TextType::class,
            [
                'label' => 'Prénom',
                'attr'  => [
                    'placeholder' => 'Prénom',
                ],
            ]
        );
        $builder->add(
            'username',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Identifiant',
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\User",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
