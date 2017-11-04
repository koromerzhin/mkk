<?php

namespace Mkk\PublicBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResettingType extends LibAbstractType
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
            'plainPassword',
            Type\RepeatedType::class,
            [
                'type'            => PasswordType::class,
                'invalid_message' => 'fos_user.password.mismatch',
                'first_options'   => [
                    'attr' => [
                        'placeholder' => 'Nouveau mot de passe',
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Répéter le nouveau mot de passe',
                    ],
                ],
                'label' => 'Password',
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
            'last_username'   => '',
            'csrf_protection' => FALSE,
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
