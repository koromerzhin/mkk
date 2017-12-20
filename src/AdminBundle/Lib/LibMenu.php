<?php

namespace Mkk\AdminBundle\Lib;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Router;

abstract class LibMenu
{
    /**
     * @var array
     */
    protected $menu;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->menu      = [];
        $this->container = $container;
        $this->router    = $container->get('router');
        $this->setMenu();
    }

    /**
     * Return le menu.
     *
     * @param mixed $menus tableau
     *
     * @return array
     */
    public function get($menus): array
    {
        $newmenu = $this->verifDroit($this->menu);
        $menus   = array_merge($menus, $newmenu);

        return $menus;
    }

    /**
     * Verifie les droits pour le menu.
     *
     * @param array $menus data
     *
     * @return array
     */
    private function verifDroit(array $menus): array
    {
        $newmenu = [];
        foreach ($menus as $menu) {
            if (isset($menu['url'])) {
                $droit = $this->isDroit($menu['url']);
                if ($droit) {
                    $newmenu[] = $menu;
                }
            } elseif (isset($menu['sousmenu'])) {
                $data = $this->verifDroit($menu['sousmenu']);
                if (0 !== count($data)) {
                    $menu['sousmenu'] = $data;
                    $newmenu[]        = $menu;
                }
            }
        }

        return $newmenu;
    }

    /**
     * Verifie le droit de la route.
     *
     * @param string $url route
     *
     * @return bool
     */
    private function isDroit(string $url): bool
    {
        $etat             = FALSE;
        $actionManager    = $this->container->get('bdd.action_manager');
        $actionRepository = $actionManager->getRepository();
        $token            = $this->container->get('security.token_storage')->getToken();
        $user             = $token->getUser();
        $search           = [
          'route'    => $url,
          'refgroup' => $user->getRefGroup(),
        ];

        if ('superadmin' === $user->getRefGroup()->getCode()) {
            return TRUE;
        }

        $action = $actionRepository->findOneBy($search);
        if ($action) {
            $etat = $action->isEtat();
        }

        return $etat;
    }
}
