<?php

namespace Mkk\AdminBundle\Menu;

use Mkk\AdminBundle\Lib\LibMenu;

class AdminMenu extends LibMenu
{
    /**
     * Génére le menu.
     *
     * @return void
     */
    protected function setMenu(): void
    {
        $paramMenu    = $this->setParamMenu();
        $this->menu[] = [
              'libelle' => 'Accueil',
              'url'     => 'site.index',
              'target'  => '_blank',
        ];
        $this->menu[] = [
                'libelle' => 'Fichiers',
                'url'     => 'admin.filemanager.fichier',
        ];
        $this->menu[] = [
                'libelle' => 'Dossiers',
                'url'     => 'admin.filemanager.dossier',
        ];
        $this->menu[] = [
            'libelle'  => 'Admin',
            'sousmenu' => [
                            [
                            'libelle' => 'Droits',
                            'url'     => 'admin.droit.index',
                            ],
                            [
                            'libelle'  => 'Templates',
                            'sousmenu' => [
                            [
                            'libelle' => 'Liste',
                            'url'     => 'admin.templates.index',
                            ],
                            [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.templates.form',
                            ],
                            ],
                            ],
                            [
                            'libelle'  => 'Page',
                            'sousmenu' => [
                            [
                            'libelle' => 'Liste',
                            'url'     => 'admin.page.index',
                            ],
                            [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.page.form',
                            ],
                            ],
                            ],
                            [
                            'libelle'  => 'Editorial',
                            'sousmenu' => [
                            [
                            'libelle' => 'Liste',
                            'url'     => 'admin.edito.index',
                            ],
                            [
                            'libelle' => 'Ajouter',
                            'url'     => 'admin.edito.form',
                            ],
                            ],
                            ],
                            [
                            'libelle'  => 'Param',
                            'sousmenu' => $paramMenu,
                            ],
            ],
        ];
    }

    /**
     * Génére les routes pour les paramètres.
     *
     * @return array
     */
    private function setParamMenu(): array
    {
        $paramMenu = [
                [
                        'libelle' => 'Uploads',
                        'url'     => 'admin.param.upload',
                ],
                [
                        'libelle' => 'Api',
                        'url'     => 'admin.param.api',
                ],
                [
                        'libelle' => 'Blog',
                        'url'     => 'admin.param.blog',
                ],
                [
                        'libelle' => 'Evenement',
                        'url'     => 'admin.param.evenement',
                ],
                [
                        'libelle' => 'Interface',
                        'url'     => 'admin.param.interface',
                ],
                [
                        'libelle' => 'Listing',
                        'url'     => 'admin.param.listing',
                ],
                [
                        'libelle' => 'Base de données',
                        'url'     => 'admin.param.bdd',
                ],
                [
                        'libelle' => 'Login',
                        'url'     => 'admin.param.login',
                ],
                [
                        'libelle' => 'Média',
                        'url'     => 'admin.param.media',
                ],
                [
                        'libelle' => 'Robots.txt',
                        'url'     => 'admin.param.robotstxt',
                ],
                [
                        'libelle' => 'Site',
                        'url'     => 'admin.param.site',
                ],
                [
                        'libelle' => 'Tableau de bord',
                        'url'     => 'admin.param.tableaubord',
                ],
                [
                        'libelle' => 'Etablissements',
                        'url'     => 'admin.param.etablissement',
                ],
                [
                        'libelle' => 'Tags',
                        'url'     => 'admin.param.tag',
                ],
                [
                        'libelle' => 'TinyMCE',
                        'url'     => 'admin.param.tinymce',
                ],
        ];

        $routes = $this->router->getRouteCollection()->all();
        foreach ($routes as $route => $data) {
            $defaults   = $data->getDefaults();
            $controller = $defaults['_controller'];
            $test1      = 0 !== substr_count($route, 'admin.param.');
            $test2      = 0 === substr_count($controller, 'Mkk');
            $test3      = 0 === substr_count($route, '.upload');
            if ($test1 && $test2 && $test3) {
                $paramMenu[] = [
                                'libelle' => "{$route}.libelle",
                                'url'     => $route,
                            ];
            }
        }

        return $paramMenu;
    }
}
