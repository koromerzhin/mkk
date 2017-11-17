<?php

namespace Mkk\AdminBundle\Form\Group;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardType extends LibAbstractType
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
            'envoyer',
            Type\SubmitType::class
        );
        $builder->add(
            'nom',
            Type\TextType::class
        );
        $builder->add(
            'code',
            Type\TextType::class
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
                'data_class' => "{$namespace}\SiteBundle\Entity\Group",
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
        return 'group';
    }
}
