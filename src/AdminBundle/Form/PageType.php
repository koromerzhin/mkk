<?php

namespace Mkk\AdminBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends LibAbstractType
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
            'titre',
            Type\TextType::class,
            [
                'label' => 'Titre',
            ]
        );
        $builder->add(
            'filevideo',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Video',
                'attr'     => [
                    'data-upload' => 'admin.page.upload.avatarvideo',
                ],
            ]
        );
        $builder->add(
            'fileimage',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image',
                'attr'     => [
                    'data-upload' => 'admin.page.upload.avatarimage',
                ],
            ]
        );
        $builder->add(
            'filefondimage',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Fond Image',
                'attr'     => [
                    'data-upload' => 'admin.page.upload.avatarfondimage',
                ],
            ]
        );
        $builder->add(
            'filefiligramme',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Filigramme',
                'attr'     => [
                    'data-upload' => 'admin.page.upload.avatarfiligramme',
                ],
            ]
        );
        $builder->add(
            'filegalerie',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Galerie',
                'attr'     => [
                    'data-upload' => 'admin.page.upload.avatargalerie',
                ],
            ]
        );
        $builder->add(
            'url',
            Type\TextType::class,
            [
                'label' => 'url',
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
            'css',
            Type\TextareaType::class,
            [
                'label'    => 'Css',
                'required' => FALSE,
                'attr'     => [
                    'rows' => 40,
                ],
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
                'data_class' => "{$namespace}\SiteBundle\Entity\Page",
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
        return 'page';
    }
}
