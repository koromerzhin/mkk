<?php

namespace Mkk\AdminBundle\Form\Enseigne;

use Mkk\AdminBundle\Form\Traits\EtablissementTrait;
use Mkk\SiteBundle\Lib\LibAbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardType extends LibAbstractType
{
    use EtablissementTrait;

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
                'data_class' => "{$namespace}\SiteBundle\Entity\Etablissement",
                'params'     => [],
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
        return 'etablissement';
    }
}
