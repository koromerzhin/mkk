<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class EvenementMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Evenement',
            'sousmenu' => [
                [
                    'libelle' => 'Liste',
                    'url'     => 'admin.evenement.index',
                ],
                [
                    'libelle' => 'Ajouter',
                    'url'     => 'admin.evenement.form',
                ],
                [
                    'libelle'  => 'Catégories',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.evenement.categorie.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.evenement.categorie.form',
                        ],
                    ],
                ],
            ],
        ];
    }
}
