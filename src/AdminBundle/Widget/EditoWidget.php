<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class EditoWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.edito_manager');
        $this->info    = 1;
        $this->titre   = 'Edito';
    }
}
