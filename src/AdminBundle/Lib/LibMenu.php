<?php

namespace Mkk\AdminBundle\Lib;

abstract class LibMenu
{
    /**
     * @var array
     */
    protected $menu;

    /**
     * Init.
     */
    public function __construct()
    {
        $this->menu = [];
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
