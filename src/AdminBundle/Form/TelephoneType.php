<?php

namespace Mkk\AdminBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelephoneType extends LibAbstractType
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
            Type\HiddenType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class' => 'InputTelType',
                ],
            ]
        );
        $builder->add(
            'pays',
            Type\HiddenType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class' => 'InputTelPays',
                ],
            ]
        );
        $builder->add(
            'utilisation',
            Type\TextType::class,
            [
                'label'    => 'Utilisation',
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'InputTelUtilisation',
                    'placeholder' => 'Utilisation',
                ],
            ]
        );
        $builder->add(
            'chiffre',
            Type\TextType::class,
            [
                'label'    => 'Chiffre',
                'required' => FALSE,
                'attr'     => [
                    'class'        => 'InputTelChiffre',
                    'autocomplete' => 'off',
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
        $resolver->setDefaults(
            [
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Telephone",
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
        return 'telephone';
    }
}
