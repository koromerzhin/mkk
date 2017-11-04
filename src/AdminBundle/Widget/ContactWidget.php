<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class ContactWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.user_manager');
        $this->url     = [
            'show' => 'admin.contact.form',
            'new'  => 'admin.contact.form',
            'list' => 'admin.contact.index',
        ];

        $this->params = [
            'data' => [
                'contact' => 1,
            ],
        ];

        $this->list  = 1;
        $this->titre = 'Contact';
    }
}
