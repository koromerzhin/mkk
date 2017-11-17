<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class TemplatesWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.templates_manager');
        $this->url     = [
            'show' => 'admin.templates.form',
            'new'  => 'admin.templates.form',
            'list' => 'admin.templates.index',
        ];

        $this->list  = 1;
        $this->titre = 'Templates';
    }
}
