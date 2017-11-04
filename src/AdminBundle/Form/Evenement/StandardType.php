<?php

namespace Mkk\AdminBundle\Form\Evenement;

use Mkk\AdminBundle\Form\Collection\AdressesType;
use Mkk\AdminBundle\Form\Collection\EmailsType;
use Mkk\AdminBundle\Form\Collection\LiensType;
use Mkk\AdminBundle\Form\Collection\LieuxType;
use Mkk\AdminBundle\Form\Collection\PrixsType;
use Mkk\AdminBundle\Form\Collection\TelephonesType;
use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\OuiNonType;
use Mkk\SiteBundle\Type\WysiwygType;
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
            'filevignette',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image',
                'attr'     => [
                    'data-upload' => 'admin.evenement.upload.vignette',
                ],
            ]
        );
        $builder->add(
            'filegalerie',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Galerie',
                'attr'     => [
                    'data-upload' => 'admin.evenement.upload.galerie',
                ],
            ]
        );
        $builder->add(
            'copyright',
            WysiwygType::class,
            [
                'label'    => 'Copyright',
                'required' => FALSE,
            ]
        );
        if (1 === $options['adresses']) {
            $builder->add(
                'emplacementadresses',
                Type\CollectionType::class,
                [
                    'required'     => FALSE,
                    'entry_type'   => AdressesType::class,
                    'allow_add'    => FALSE,
                    'delete_empty' => FALSE,
                    'allow_delete' => FALSE,
                    'by_reference' => FALSE,
                ]
            );
            $builder->add(
                'etablissements',
                Type\CollectionType::class,
                [
                    'required'     => FALSE,
                    'entry_type'   => LieuxType::class,
                    'allow_add'    => FALSE,
                    'delete_empty' => FALSE,
                    'allow_delete' => FALSE,
                    'by_reference' => FALSE,
                ]
            );
        }

        if (1 === $options['place']) {
            $builder->add(
                'type',
                Type\ChoiceType::class,
                [
                    'expanded' => TRUE,
                    'label'    => 'Type de programmation',
                    'choices'  => [
                        '0' => 'Créneaux horaires',
                        '1' => 'PASS',
                    ],
                ]
            );
            $builder->add(
                'totalnbplace',
                Type\IntegerType::class,
                [
                    'label' => 'Place',
                    'attr'  => ['min' => 0],
                ]
            );
            $builder->add(
                'placeillimite',
                OuiNonType::class,
                [
                    'label' => 'Place illimité',
                ]
            );
        }

        $builder->add(
            'categorie',
            Type\TextType::class,
            [
                'label'    => 'Catégorie',
                'required' => TRUE,
                'attr'     => [
                    'placeholder' => 'Catégorie',
                    'data-url'    => 'admin.evenement.search.categorie',
                ],
            ]
        );
        $builder->add(
            'prixs',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => PrixsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Prix',
            ]
        );
        $builder->add(
            'telephones',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TelephonesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Téléphones',
            ]
        );
        $builder->add(
            'liens',
            Type\CollectionType::class,
            [
               'required'     => FALSE,
               'entry_type'   => LiensType::class,
               'allow_add'    => TRUE,
               'delete_empty' => TRUE,
               'allow_delete' => TRUE,
               'by_reference' => FALSE,
               'label'        => 'Liens',
            ]
        );
        $builder->add(
            'emails',
            Type\CollectionType::class,
            [
               'required'     => FALSE,
               'entry_type'   => EmailsType::class,
               'allow_add'    => TRUE,
               'delete_empty' => TRUE,
               'allow_delete' => TRUE,
               'by_reference' => FALSE,
               'label'        => 'Emails',
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
        $namespace = $this->namespace;
        $resolver->setDefaults(
            [
                'data_class' => "{$namespace}\SiteBundle\Entity\Evenement",
                'adresses'   => 0,
                'place'      => 0,
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
        return 'evenement';
    }
}
