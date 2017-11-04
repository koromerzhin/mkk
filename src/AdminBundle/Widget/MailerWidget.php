<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class MailerWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.mailer_manager');
        $this->url     = [
            'show' => 'admin.mailer.show',
            'list' => 'admin.mailer.index',
        ];

        $this->list  = 1;
        $this->titre = 'Mailer';
    }
}
