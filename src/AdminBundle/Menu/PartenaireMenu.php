<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class PartenaireMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Partenaire',
            'sousmenu' => [
                [
                    'libelle' => 'Liste',
                    'url'     => 'admin.partenaire.index',
                ],
                [
                    'libelle' => 'Ajouter',
                    'url'     => 'admin.partenaire.form',
                ],
                [
                    'libelle'  => 'Catégories',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.partenaire.categorie.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.partenaire.categorie.form',
                        ],
                    ],
                ],
            ],
        ];
    }
}
