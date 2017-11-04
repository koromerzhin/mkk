<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrixsType extends LibAbstractType
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
            'type',
            Type\TextType::class,
            [
                'label'    => 'Type',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Type',
                ],
            ]
        );
        $builder->add(
            'chiffre',
            Type\NumberType::class,
            [
                'label'    => 'Montant',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Montant',
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Prix",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
