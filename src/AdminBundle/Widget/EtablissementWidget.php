<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class EtablissementWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.etablissement_manager');
        $this->url     = [
            'show' => 'admin.etablissement.form',
            'new'  => 'admin.etablissement.form',
            'list' => 'admin.etablissement.index',
        ];

        $this->list  = 1;
        $this->titre = 'Etablissement';
    }
}
