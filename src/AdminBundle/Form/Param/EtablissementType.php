<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\EtablissementsType;
use Mkk\AdminBundle\Lib\LibParamType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class EtablissementType extends LibParamType
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
            Type\SubmitType::class
        );
        $builder->add(
            'type_etablissement',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => EtablissementsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'label'        => "Type d'établissement",
            ]
        );
        $builder->add(
            'etablissement_mediaphotoequipe',
            OuiNonType::class,
            [
                'label' => "Photo L'équipe",
            ]
        );
        $builder->add(
            'etablissement_position',
            OuiNonType::class,
            [
                'label' => 'Gestion de la position',
            ]
        );
        $builder->add(
            'etablissement_mediaphotoenexterieur',
            OuiNonType::class,
            [
                'label' => 'Photo En extérieur',
            ]
        );
        $builder->add(
            'etablissement_mediaphotoeninterieur',
            OuiNonType::class,
            [
                'label' => 'Photo En intérieur',
            ]
        );
        $builder->add(
            'etablissement_mediaimages',
            OuiNonType::class,
            [
                'label' => "Galerie d'images",
            ]
        );
        $builder->add(
            'etablissement_medialogo',
            OuiNonType::class,
            [
                'label' => 'Logo',
            ]
        );
        $builder->add(
            'etablissement_ape',
            OuiNonType::class,
            [
                'label' => 'APE',
            ]
        );
        $builder->add(
            'etablissement_factures',
            OuiNonType::class,
            [
                'label' => 'Factures',
            ]
        );
        $builder->add(
            'etablissement_tva',
            OuiNonType::class,
            [
                'label' => 'TVA intracommunautaire',
            ]
        );
        $builder->add(
            'etablissement_accueil',
            OuiNonType::class,
            [
                'label' => 'mettre en avant accueil',
            ]
        );
        $builder->add(
            'etablissement_siret',
            OuiNonType::class,
            [
                'label' => 'SIRET',
            ]
        );
        $builder->add(
            'etablissement_ca',
            OuiNonType::class,
            [
                'label' => 'CA',
            ]
        );
        $builder->add(
            'etablissement_nbrsalarie',
            OuiNonType::class,
            [
                'label' => 'Nombre de salarié',
            ]
        );
        $builder->add(
            'etablissement_horaire',
            OuiNonType::class,
            [
                'label' => 'formulaire horaires',
            ]
        );
        $builder->add(
            'etablissement_secteur',
            OuiNonType::class,
            [
                'label' => "Affichage secteur d'activité",
            ]
        );
        unset($options);
    }
}
