<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\CivilitesType;
use Mkk\AdminBundle\Form\Collection\TagsType;
use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class TagType extends LibParamType
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
            'tags_telephone',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Utilisateur',
            ]
        );
        $builder->add(
            'tags_telephone_etablissement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Établissement',
            ]
        );
        $builder->add(
            'tags_telephone_evenement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Évenement',
            ]
        );
        $builder->add(
            'tags_email',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Utilisateur',
            ]
        );
        $builder->add(
            'tags_email_etablissement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Établissement',
            ]
        );
        $builder->add(
            'tags_email_evenement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Évenement',
            ]
        );
        $builder->add(
            'tags_adresse',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Utilisateur',
            ]
        );
        $builder->add(
            'tags_adresse_etablissement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Établissement',
            ]
        );
        $builder->add(
            'tags_adresse_evenement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Évenement',
            ]
        );
        $builder->add(
            'tags_client',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TagsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Tags client',
            ]
        );
        $builder->add(
            'civilite',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => CivilitesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => 'Civilité',
            ]
        );
        unset($options);
    }
}
