<?php

namespace Mkk\AdminBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeoType extends LibAbstractType
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
            'pattern',
            Type\TextType::class,
            [
                'label'                => 'Pattern',
                'required'             => FALSE,
                                'attr' => [
                                    'disabled' => 'disabled',
                                ],
            ]
        );
        $builder->add(
            'titre',
            Type\TextType::class,
            [
                'label'    => 'Titre',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'description',
            Type\TextType::class,
            [
                'label'    => 'Description',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'keywords',
            Type\TextType::class,
            [
                'label'    => 'Mots clefs',
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
                'data_class'      => "{$namespace}\SiteBundle\Entity\Metariane",
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
        return 'seo';
    }
}
