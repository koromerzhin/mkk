<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class UserMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Utilisateur',
            'sousmenu' => [
                [
                    'libelle' => 'Liste',
                    'url'     => 'admin.user.index',
                ],
                [
                    'libelle' => 'Ajouter',
                    'url'     => 'admin.user.form',
                ],
                [
                    'libelle'  => 'Groupes',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.user.group.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.user.group.form',
                        ],
                    ],
                ],
            ],
        ];
    }
}
