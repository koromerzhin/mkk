<?php

namespace Mkk\AdminBundle\Form\Collection;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WidgetsType extends LibAbstractType
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
            'group',
            Type\HiddenType::class
        );
        $builder->add(
            'nom',
            Type\TextType::class,
            [
                'label'    => 'Group',
                'required' => FALSE,
                'attr'     => [
                    'readonly'    => 'readonly',
                    'placeholder' => 'Group',
                ],
            ]
        );
        $builder->add(
            'widget',
            Type\TextType::class,
            [
                'label'    => 'Group',
                'required' => FALSE,
                'attr'     => [
                    'readonly'    => 'readonly',
                    'placeholder' => 'Widget',
                ],
            ]
        );
        $builder->add(
            'etat',
            OuiNonType::class,
            [
                'label' => 'Commentaire activé',
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
