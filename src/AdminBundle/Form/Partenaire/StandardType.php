<?php

namespace Mkk\AdminBundle\Form\Partenaire;

use Mkk\SiteBundle\Lib\LibAbstractType;
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
            'fileimage',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Photo',
                'attr'     => [
                    'data-upload' => 'admin.partenaire.upload.image',
                ],
            ]
        );
        $builder->add(
            'categorie',
            Type\TextType::class,
            [
                'label'    => 'Catégorie',
                'required' => TRUE,
                'attr'     => [
                    'placeholder' => 'Catégorie',
                    'data-url'    => 'admin.partenaire.search.categorie',
                ],
            ]
        );
        $builder->add(
            'nom',
            Type\TextType::class,
            [
                'label' => 'Nom',
            ]
        );
        $builder->add(
            'url',
            Type\UrlType::class,
            [
                'label' => 'Site internet',
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
                'data_class' => "{$namespace}\SiteBundle\Entity\Partenaire",
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
        return 'partenaire';
    }
}
