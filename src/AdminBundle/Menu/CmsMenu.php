<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class CmsMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $this->menu[] = [
            'libelle'  => 'CMS',
            'sousmenu' => [
                [
                    'libelle'  => 'Etablissement',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.etablissement.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'id'      => 'LienAjouterEtablissement',
                            'url'     => 'admin.etablissement.new',
                        ],
                    ],
                ],
                [
                    'libelle'                 => 'SEO',
                                        'url' => 'admin.seo.index',
                ],
                [
                    'libelle'  => 'Diaporama',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.diaporama.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.diaporama.form',
                        ],
                    ],
                ],
                [
                    'libelle'  => 'Note interne',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.noteinterne.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.noteinterne.form',
                        ],
                    ],
                ],
                [
                    'libelle'  => 'Bookmark',
                    'sousmenu' => [
                        [
                            'libelle' => 'Liste',
                            'url'     => 'admin.bookmark.index',
                        ],
                        [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.bookmark.form',
                        ],
                        [
                            'libelle' => 'Tag',
                            'url'     => 'admin.bookmark.tag.index',
                        ],
                    ],
                ],
            ],
        ];
    }
}
