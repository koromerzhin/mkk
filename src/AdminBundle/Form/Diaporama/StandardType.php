<?php

namespace Mkk\AdminBundle\Form\Diaporama;

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
            'fileimages',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Galerie',
                'attr'     => [
                    'data-upload' => 'admin.diaporama.upload.images',
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
                'data_class' => "{$this->namespace}\SiteBundle\Entity\Diaporama",
                ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return 'diaporama';
    }
}
