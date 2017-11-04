<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class BlogMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'Blog',
            'sousmenu' => [
                [
                    'libelle' => 'Liste',
                    'url'     => 'admin.blog.index',
                ],
                [
                    'libelle' => 'Ajouter',
                    'url'     => 'admin.blog.form',
                ],
                [
                    'libelle'  => 'Catégories',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.blog.categorie.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.blog.categorie.form',
                        ],
                    ],
                ],
                [
                    'libelle' => 'Tag',
                    'url'     => 'admin.blog.tag.index',
                ],
            ],
        ];
    }
}
