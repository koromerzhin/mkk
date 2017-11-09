<?php

namespace Mkk\AdminBundle\Form\Bookmark;

use Mkk\SiteBundle\Lib\LibAbstractType;
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
            'submit',
            Type\SubmitType::class
        );
        $builder->add(
            'description',
            WysiwygType::class,
            [
                'label'    => 'Description',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'meta_description',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Description',
            ]
        );
        $builder->add(
            'meta_keywords',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Mots clefs',
            ]
        );
        $builder->add(
            'titre',
            Type\TextType::class,
            [
                'label' => 'Titre',
                'attr'  => ['placeholder' => 'Titre'],
            ]
        );
        $builder->add(
            'alias',
            Type\TextType::class,
            [
                'label'    => 'Alias',
                'attr'     => ['placeholder' => 'Alias'],
                'required' => FALSE,
            ]
        );
        $builder->add(
            'fileimage',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image',
                'attr'     => [
                    'data-upload' => 'admin.bookmark.upload.image',
                ],
            ]
        );
        $builder->add(
            'url',
            Type\UrlType::class,
            [
                'label'    => 'Url',
                'attr'     => ['placeholder' => 'Url'],
                'required' => FALSE,
            ]
        );
        $builder->add(
            'tag',
            Type\TextType::class,
            [
                'label'    => 'Tags',
                'attr'     => ['placeholder' => 'Tags'],
                'mapped'   => FALSE,
                'required' => FALSE,
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
                'data_class' => "{$namespace}\SiteBundle\Entity\Bookmark",
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
        return 'bookmark';
    }
}
