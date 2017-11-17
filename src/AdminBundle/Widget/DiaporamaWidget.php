<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class DiaporamaWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.diaporama_manager');
        $this->url     = [
            'show' => 'admin.diaporama.form',
            'new'  => 'admin.diaporama.form',
            'list' => 'admin.diaporama.index',
        ];

        $this->list  = 1;
        $this->titre = 'Diaporama';
    }
}
