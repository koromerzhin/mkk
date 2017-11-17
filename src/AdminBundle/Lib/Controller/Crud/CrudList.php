<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Doctrine\ORM\Query;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Service\ParamService;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

class CrudList
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ActionService
     */
    private $actionService;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TableService
     */
    private $manager;

    /**
     * @var LibRepository
     */
    private $repository;

    /**
     * @var ParamService
     */
    private $paramService;

    /**
     * @var array
     */
    private $show;
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var string
     */
    private $defaultDirection;

    /**
     * @var string
     */
    private $defaultSort;

    /**
     * @var Controller
     */
    private $controller;

    private $token;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var bool
     */
    private $disableform;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container        = $container;
        $this->router           = $container->get('router');
        $this->requestStack     = $container->get('request_stack');
        $this->request          = $this->requestStack->getCurrentRequest();
        $this->paramService     = $container->get(ParamService::class);
        $this->token            = $container->get('security.token_storage')->getToken();
        $this->paginator        = $container->get('knp_paginator');
        $this->actionService    = $this->container->get(ActionService::class);
        $this->defaultSort      = 'id';
        $this->defaultDirection = 'asc';
        $this->disableform      = FALSE;
    }

    /**
     * set le controller.
     *
     * @param Controller $controller controller par défaut
     *
     * @return void
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Génére le render List.
     *
     * @param array $params paramètres
     *
     * @return Response
     */
    public function render($params = []): Response
    {
        $infoRoute  = $this->request->attributes->all();
        $breadcrumb = [
            'libelle' => 'Liste',
            'url'     => $infoRoute['_route'],
            'params'  => $infoRoute['_route_params'],
        ];
        $this->controller->breadcrumbService->add($breadcrumb);
        $params                  = array_merge($params, $this->request->query->all());
        $params['user']          = $this->token->getUser();
        $params['params_config'] = $this->paramService->listing();
        $query                   = call_user_func_array([$this->repository, 'searchAdminList'], [$params]);
        $paginator               = $this->setPaginator($query);
        $translations            = $this->manager->getTranslations();
        $methods                 = get_class_methods($this->controller);
        if (in_array('listCrud', $methods)) {
            $this->controller->listCrud($this);
        }

        $urlNew = str_replace(['index', 'page'], 'form', $infoRoute['_route']);
        if ($this->hasRoutes($urlNew) && !$this->disableform) {
            $this->actionService->addBtnNew($urlNew);
        }

        $urlDelete = str_replace(['index', 'page'], 'delete', $infoRoute['_route']);
        if ($this->hasRoutes($urlDelete)) {
            $this->actionService->addBtnDelete($urlDelete);
        }

        $urlVider = str_replace(['index', 'page'], 'vider', $infoRoute['_route']);
        if ($this->hasRoutes($urlVider)) {
            $this->actionService->addBtnVider($urlVider);
        }

        $urlPosition = str_replace(['index', 'page'], 'position', $infoRoute['_route']);
        if ($this->hasRoutes($urlPosition)) {
            $this->actionService->addBtnPosition($urlPosition);
        }

        $render = $this->controller->render(
            'MkkAdminBundle:Crud:list.html.twig',
            [
                'sortList'     => $this->show,
                'paginator'    => $paginator,
                'translations' => $translations,
            ]
        );

        return $render;
    }

    /**
     * Donne l'accès a ActionService.
     *
     * @return ActionService
     */
    public function getActionService(): ActionService
    {
        return $this->actionService;
    }

    /**
     * Gestion de la direction par défaut.
     *
     * @param string $direction string
     *
     * @return void
     */
    public function setDefaultDirection($direction): void
    {
        $this->defaultDirection = $direction;
    }

    /**
     * Gestion du sort par défaut.
     *
     * @param string $sort ASC ou DESC
     *
     * @return void
     */
    public function setDefaultSort($sort): void
    {
        $this->defaultSort = 'li.' . $sort;
    }

    /**
     * Ajoute un champs pour la table.
     *
     * @param string $nom  nom
     * @param array  $data data
     *
     * @return self
     */
    public function addShow($nom, $data = []): self
    {
        $new = array_merge(
            [
                'col'  => $nom,
                'id'   => FALSE,
                'sort' => FALSE,
            ],
            $data
        );

        if (!isset($new['label'])) {
            $new['label'] = $nom;
        }

        $this->show[$nom] = $new;

        return $this;
    }

    /**
     * Ajoute un champs pour la table le champs aura le lien pour le formulaire.
     *
     * @param string $nom  nom
     * @param array  $data data
     *
     * @return self
     */
    public function addShowIdentifier($nom, $data = []): self
    {
        $data['id'] = TRUE;
        $this->addShow($nom, $data);

        return $this;
    }

    /**
     * Indique le manager.
     *
     * @param TableService $manager pour savoir quel table utiliser
     *
     * @return void
     */
    public function setManager(TableService $manager): void
    {
        $this->manager    = $manager;
        $this->repository = $this->manager->getRepository();
    }

    /**
     * Désactive le lien pour le formulaire.
     *
     * @return void
     */
    public function disableForm(): void
    {
        $this->disableform = TRUE;
    }

    /**
     * Verifie si la route existe.
     *
     * @param string $verifUrl url
     *
     * @return bool
     */
    private function hasRoutes(string $verifUrl): bool
    {
        $retour = FALSE;
        $routes = $this->router->getRouteCollection()->all();
        foreach (array_keys($routes) as $name) {
            if ($name === $verifUrl) {
                $retour = TRUE;
                break;
            }
        }

        return $retour;
    }

    /**
     * Génére la pagination.
     *
     * @param mixed|Query $query d'après EntityManager
     *
     * @return SlidingPagination
     */
    private function setPaginator($query): SlidingPagination
    {
        $param = $this->paramService->listing();
        $route = $this->request->get('_route');
        $limit = $this->setLimitDefault();

        list($module) = explode('_', $route);
        if (isset($param['module_listing'])) {
            foreach ($param['module_listing'] as $tab) {
                if ($tab['module'] === $module) {
                    $limit = (int) $tab['val'];
                }
            }
        }

        if (0 !== (int) $this->request->query->get('limit')) {
            $limit = (int) $this->request->query->get('limit');
        }

        $page = (int) $this->request->get('page');
        if ($page <= 0) {
            $page = 1;
        }

        $pagination = $this->paginator->paginate(
            $query, // query NOT result
            $page/*page number*/,
            $limit// limit per page
        );
        if (!$this->request->query->get('sort') && !$this->request->query->get('direction')) {
            $pagination->setParam('sort', $this->defaultSort);
            $pagination->setParam('direction', $this->defaultDirection);
        }

        $route = $pagination->getRoute();
        $pagination->setUsedRoute($route);

        return $pagination;
    }

    /**
     * Donne la limit max pour les paginations.
     *
     * @return int
     */
    private function setLimitDefault(): int
    {
        $param = $this->paramService->listing();
        $route = $this->request->get('_route');
        $limit = 50;
        if (0 !== (int) substr_count($route, 'admin.') && isset($param['longueurliste']) && 0 !== $param['longueurliste']) {
            $limit = $param['longueurliste'];
        }

        if (0 === (int) substr_count($route, 'admin.') && isset($param['publicliste']) && 0 !== $param['publicliste']) {
            $limit = $param['publicliste'];
        }

        return (int) $limit;
    }
}
