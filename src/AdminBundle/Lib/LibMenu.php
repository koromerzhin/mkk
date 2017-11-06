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
        $menus = array_merge($menus, $this->menu);

        return $menus;
    }
}
