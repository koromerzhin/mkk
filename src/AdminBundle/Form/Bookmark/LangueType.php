<?php

namespace Mkk\AdminBundle\Form\Bookmark;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LangueType extends LibAbstractType
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
                'data_class'      => "{$namespace}\SiteBundle\Entity\Bookmark",
                'csrf_protection' => FALSE,
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
