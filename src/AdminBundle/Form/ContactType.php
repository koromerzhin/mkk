<?php

namespace Mkk\AdminBundle\Form;

use Mkk\AdminBundle\Form\Collection\AdressesType;
use Mkk\AdminBundle\Form\Collection\EmailsType;
use Mkk\AdminBundle\Form\Collection\TelephonesType;
use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends LibAbstractType
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
            'nom',
            Type\TextType::class,
            [
                'label'    => 'Nom',
                'required' => FALSE,
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
            'group',
            Type\TextType::class,
            [
                'label' => 'Groupe',
                'attr'  => [
                    'placeholder' => 'Groupe',
                    'data-url'    => 'admin.contact.search.group',
                ],
            ]
        );
        $builder->add(
            'observations',
            Type\TextareaType::class,
            [
                'label'    => 'Observations',
                'required' => FALSE,
                'attr'     => ['rows' => 6],
            ]
        );
        $builder->add(
            'type',
            Type\ChoiceType::class,
            [
                'label'    => 'Type de contact',
                'required' => FALSE,
                'choices'  => [
                    'prospect' => 'Prospect',
                    'client'   => 'client',
                ],
            ]
        );
        $builder->add(
            'tags',
            Type\TextType::class,
            [
                'label'    => 'Tags',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'douanier',
            Type\ChoiceType::class,
            [
                'label'       => 'Statut douanier',
                'required'    => FALSE,
                'placeholder' => 'choisissez le statut douanier',
                'choices'     => [
                    'france'             => 'France',
                    'intracommunautaire' => 'Intra-communautaire',
                    'export'             => 'Export',
                ],
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
        return 'contact';
    }
}
