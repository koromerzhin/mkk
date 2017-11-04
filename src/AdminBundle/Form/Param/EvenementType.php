<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Mkk\SiteBundle\Type\OuiNonType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class EvenementType extends LibParamType
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
            'evenement_place',
            OuiNonType::class,
            [
                'label' => 'Chaque evènement à un nombre de place',
            ]
        );
        $builder->add(
            'evenement_etat',
            OuiNonType::class,
            [
                'label' => 'Activer etat',
            ]
        );
        $builder->add(
            'evenement_couleur',
            Type\TextType::class,
            [
                'label'    => 'Couleur disponible',
                'required' => FALSE,
            ]
        );
        unset($options);
    }
}
