<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairesType extends LibAbstractType
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
            'jour',
            Type\HiddenType::class,
            [
                'required' => TRUE,
            ]
        );
        $builder->add(
            'dm',
            Type\TextType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'HoraireAM',
                    'placeholder' => '00:00',
                ],
            ]
        );
        $builder->add(
            'fm',
            Type\TextType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'HoraireAM',
                    'placeholder' => '00:00',
                ],
            ]
        );
        $builder->add(
            'da',
            Type\TextType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'HorairePM',
                    'placeholder' => '00:00',
                ],
            ]
        );
        $builder->add(
            'fa',
            Type\TextType::class,
            [
                'required' => FALSE,
                'attr'     => [
                    'class'       => 'HorairePM',
                    'placeholder' => '00:00',
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
            'data_class'      => "{$this->namespace}\SiteBundle\Entity\Horaire",
            'csrf_protection' => FALSE,
            ]
        );
    }
}
