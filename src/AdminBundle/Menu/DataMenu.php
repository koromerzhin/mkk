<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class DataMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Data',
            'sousmenu' => [
                [
                    'libelle' => 'Adresses',
                    'url'     => 'admin.adresse.index',
                ],
                [
                    'libelle' => 'Mailer',
                    'url'     => 'admin.mailer.index',
                ],
                [
                    'libelle' => 'Liens',
                    'url'     => 'admin.lien.index',
                ],
                [
                    'libelle' => 'Téléphones',
                    'url'     => 'admin.telephone.index',
                ],
            ],
        ];
    }
}
