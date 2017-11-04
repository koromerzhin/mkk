<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementsType extends LibAbstractType
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
            'code',
            Type\TextType::class,
            [
                'label'    => 'Code',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Code',
                ],
            ]
        );
        $builder->add(
            'nom',
            Type\TextType::class,
            [
                'label'    => 'Nom',
                'required' => FALSE,
                'attr'     => [
                    'placeholder' => 'Nom',
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
            'csrf_protection' => FALSE,
            ]
        );
    }
}
