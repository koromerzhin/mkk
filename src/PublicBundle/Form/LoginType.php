<?php

namespace Mkk\PublicBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends LibAbstractType
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
            Type\SubmitType::class,
            [
                'label' => 'Se connecter',
            ]
        );
        $builder->add(
            '_username',
            Type\TextType::class,
            [
                'label' => 'Pseudo / E-mail',
                'data'  => $options['last_username'],
                'attr'  => [
                    'autocomplete'     => 'off',
                    'placeholder'      => 'Pseudo / E-mail',
                    'data-labelactive' => 1,
                ],
            ]
        );
        $builder->add(
            '_password',
            Type\PasswordType::class,
            [
                'label' => 'Password',
                'attr'  => [
                    'autocomplete' => 'off',
                    'placeholder'  => 'Password',
                ],
            ]
        );
        $builder->add(
            '_remember_me',
            Type\CheckboxType::class,
            [
                'label'    => 'Se souvenir de moi',
                'required' => FALSE,
                'mapped'   => FALSE,
            ]
        );
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
