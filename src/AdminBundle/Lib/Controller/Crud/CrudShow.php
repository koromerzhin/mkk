<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class CrudShow
{
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
     * @var LibController
     */
    private $controller;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     *  @var FlashBag
     */
    private $flashBag;

    /**
     * @var Session
     */
    private $session;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->requestStack = $container->get('request_stack');
        $this->router       = $container->get('router');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->session      = $this->request->getSession();
        $this->flashBag     = $this->session->getFlashBag();
    }

    /**
     * Set le controller.
     *
     * @param Controller $controller classe par défaut
     *
     * @return void
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Rendu pour vider une table.
     *
     * @return Response
     */
    public function render(): Response
    {
        $infoRoute = $this->request->attributes->all();
        $entity    = $this->repository->find($infoRoute['_route_params']['id']);
        if (!$entity) {
            $url      = $this->router->generate(str_replace('form', 'index', $infoRoute['_route']));
            $redirect = new on\RedirectResponse($url);

            return $redirect;
        }

        $data    = get_class_methods($entity);
        $methods = [];
        foreach ($data as $method) {
            if (0 !== substr_count($method, 'get') && 'getId' !== $method) {
                $id           = substr($method, 3);
                $id           = strtolower($id);
                $methods[$id] = call_user_func([$entity, $method]);
            }
        }

        $name = get_class($entity);
        $name = substr($name, strrpos($name, '\\') + 1);
        $name = strtolower($name);

        $breadcrumb = [
            'libelle' => 'Formulaire',
            'url'     => $infoRoute['_route'],
            'params'  => $infoRoute['_route_params'],
        ];

        $breadcrumbService = $this->controller->breadcrumbService;
        $breadcrumbService->add($breadcrumb);
        $return = $this->controller->render(
            'MkkAdminBundle:Crud:show.html.twig',
            [
                'name'    => $name,
                'entity'  => $entity,
                'methods' => $methods,
            ]
        );

        return $return;
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
}
