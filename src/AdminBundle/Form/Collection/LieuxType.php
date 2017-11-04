<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuxType extends LibAbstractType
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
            ['label' => 'Enseigne']
        );
        $builder->add(
            'adresses',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => $this->container->get('mkk_admin.form.collection.adresse'),
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
                'entry_type'   => $this->container->get('mkk_admin.form.collection.lien'),
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
                'entry_type'   => $this->container->get('mkk_admin.form.collection.email'),
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
                'entry_type'   => $this->container->get('mkk_admin.form.collection.telephone'),
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Etablissement",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
