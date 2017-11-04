<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailsType extends LibAbstractType
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
                    'class'       => 'InputEmailUtilisation',
                    'placeholder' => 'Type',
                ],
            ]
        );
        $builder->add(
            'adresse',
            Type\EmailType::class,
            [
                'label'    => 'adresse',
                'required' => FALSE,
                'attr'     => [
                    'placeholder'  => 'adresse@test.fr',
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Email",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
