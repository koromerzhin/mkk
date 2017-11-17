<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class PartenaireWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.partenaire_manager');
        $this->url     = [
            'show' => 'admin.partenaire.form',
            'new'  => 'admin.partenaire.form',
            'list' => 'admin.partenaire.index',
        ];

        $this->list  = 1;
        $this->titre = 'Partenaire';
    }
}
