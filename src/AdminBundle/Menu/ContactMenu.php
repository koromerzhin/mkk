<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class ContactMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Contact',
            'sousmenu' => [
                [
                    'libelle' => 'Liste',
                    'url'     => 'admin.contact.index',
                ],
                [
                    'libelle' => 'Ajouter',
                    'url'     => 'admin.contact.form',
                ],
            ],
        ];
    }
}
