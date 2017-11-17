<?php

namespace Mkk\PublicBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgottenpasswordType extends LibAbstractType
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
                'label' => "J'ai perdu mon mot de passe",
            ]
        );
        $builder->add(
            'username',
            Type\TextType::class,
            [
                'label' => 'Pseudo / E-mail',
                'attr'  => [
                    'placeholder' => 'Pseudo / E-mail',
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
