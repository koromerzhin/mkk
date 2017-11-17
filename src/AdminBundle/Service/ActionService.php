<?php

namespace Mkk\AdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class ActionService
{
    /**
     * @var Request
     */
    protected $request;

    protected $controller;

    /**
     * @var array
     */
    protected $tab;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $bouton;

    /**
     * @var mixed
     */
    protected $groupvisiteur;

    /**
     * @var mixed
     */
    protected $groupsuperadmin;

    protected $route;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Init.
     *
     * @param ContainerInterface $container PHP DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->requestStack = $container->get('request_stack');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->router       = $container->get('router');
        $this->tab          = [];
        $this->route        = $this->request->attributes->get('_route');
        if ('admin.index' !== $this->route && 0 !== substr_count($this->route, 'admin.')) {
            $this->tab[] = [
                'id'   => 'BoutonDashboard',
                'url'  => 'admin.index',
                'text' => 'Dashboard',
            ];
        }

        $this->bouton = [
            'supprimer' => 0,
        ];
    }

    /**
     * Génère les actions.
     *
     * @param array $actions actions
     *
     * @return void
     */
    public function set(array $actions): void
    {
        $this->tab = $actions;
    }

    /**
     * Génère le bouton.
     *
     * @param array $actions actions
     *
     * @return void
     */
    public function add(array $actions): void
    {
        $this->tab[] = $actions;
    }

    /**
     * Génère le bouton Vider.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnPosition(string $url): void
    {
        $actions = [
            'id'   => 'BoutonPosition',
            'text' => 'Position',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Vider.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnVider(string $url): void
    {
        $actions = [
            'id'   => 'BoutonVider',
            'text' => 'Vider',
            'img'  => 'fa fa-bomb',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Activer.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnActiver(string $url): void
    {
        $actions = [
            'id'   => 'BoutonActiver',
            'text' => 'Activer',
            'img'  => 'glyphicon-thumbs-up',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Désactiver.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnDesactiver(string $url): void
    {
        $actions = [
            'id'   => 'BoutonDesactiver',
            'text' => 'D&eacute;sactiver',
            'img'  => 'glyphicon-thumbs-down',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Dupliquer.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnDupliquer(string $url): void
    {
        $actions = [
            'id'   => 'BoutonDupliquer',
            'text' => 'Dupliquer',
            'img'  => 'fa fa-files-o',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Supprimer.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnDelete(string $url): void
    {
        $actions = [
            'id'   => 'BoutonSupprimer',
            'text' => 'Supprimer',
            'img'  => 'glyphicon-trash',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Ajouter.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnAdd(string $url): void
    {
        $actions = [
            'id'   => 'BoutonAdd',
            'text' => 'Ajouter',
            'img'  => 'glyphicon-plus',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton New.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnNew($url): void
    {
        $actions = [
            'id'   => 'BoutonNew',
            'text' => 'Ajouter',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Génère le bouton Retour.
     *
     * @param string $url url
     *
     * @return void
     */
    public function addBtnReturn($url): void
    {
        $actions = [
            'id'   => 'BoutonReturn',
            'text' => 'Retour liste',
            'url'  => $url,
        ];
        $this->add($actions);
    }

    /**
     * Ajoute le bouton Save.
     *
     * @param string $id Identifiant du bouton
     *
     * @return void
     */
    public function addBtnSave(string $id): void
    {
        $actions = [
            'id'   => 'BoutonSave',
            'text' => 'Enregistrer',
            'attr' => [
                'data-submit' => $id,
            ],
        ];
        $this->add($actions);
        $actions = [
            'id'   => 'BoutonSaveAndClose',
            'text' => 'Enregistrer et fermer',
            'img'  => 'glyphicon glyphicon-save',
        ];
        $this->add($actions);
    }

    /**
     * Récupére les actions.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->tab;
    }
}
