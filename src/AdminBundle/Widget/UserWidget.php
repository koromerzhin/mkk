<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class UserWidget extends LibWidget
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
            'show' => 'admin.user.form',
            'new'  => 'admin.user.form',
            'list' => 'admin.user.index',
        ];

        $this->params = [
            'data' => [
                'user' => 1,
            ],
        ];

        $this->list  = 1;
        $this->titre = 'Utilisateur';
    }
}
