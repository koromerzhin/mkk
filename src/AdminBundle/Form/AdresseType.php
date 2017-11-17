<?php

namespace Mkk\AdminBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends LibAbstractType
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
            'type',
            Type\TextType::class,
            [
                'label'    => 'Type',
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'InputAdresseUtilisation',
                    'placeholder' => 'Type',
                ],
            ]
        );
        $builder->add(
            'info',
            Type\TextareaType::class,
            [
                'label'    => 'form.label.adresse',
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'mceNoEditor',
                    'placeholder' => 'form.label.adresse',
                ],
            ]
        );
        $builder->add(
            'cp',
            Type\TextType::class,
            [
                'label'    => 'form.label.codepostal',
                'required' => FALSE,
                'attr'     => [
                    'data-url'    => 'scripts.cpville',
                    'class'       => 'InputAdresseCp',
                    'placeholder' => 'form.label.codepostal',
                ],
            ]
        );
        $builder->add(
            'ville',
            Type\TextType::class,
            [
                'label'    => 'form.label.ville',
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'InputAdresseVille',
                    'placeholder' => 'form.label.ville',
                ],
            ]
        );
        $builder->add(
            'pays',
            Type\CountryType::class,
            [
                'label'       => 'form.label.pays',
                'required'    => FALSE,
                'data'        => 'FR',
                'placeholder' => 'Choisir le pays',
                'attr'        => [
                    'class'       => 'InputAdressePays',
                    'placeholder' => 'form.label.pays',
                ],
            ]
        );
        $builder->add(
            'gps',
            Type\TextType::class,
            [
                'mapped'   => FALSE,
                'label'    => 'GPS',
                'required' => FALSE,
                'attr'     => [
                    'class' => 'InputAdresseGps',
                ],
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
                'data_class'      => "{$namespace}\SiteBundle\Entity\Adresse",
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
        return 'adresse';
    }
}
