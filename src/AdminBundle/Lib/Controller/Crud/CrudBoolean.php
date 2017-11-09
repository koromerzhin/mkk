<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class CrudBoolean
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
     * @param string $champs champs a modifier
     *
     * @return JsonResponse
     */
    public function render(string $champs): JsonResponse
    {
        $response = [];
        $request  = $this->request;
        set_time_limit(0);
        $id = $request->request->get('id');
        if ('' === $id) {
            $json = new JsonResponse($response);

            return $json;
        }

        $etat            = $request->request->get('etat');
        $tableRepository = $this->manager->getRepository();
        $response        = ['change' => 0];
        $entity          = $tableRepository->find($id);
        if (!$entity) {
            $json = new JsonResponse($response);

            return $json;
        }

        $methods = get_class_methods($entity);
        $champs  = ucfirst($champs);
        if (!in_array("set{$champs}", $methods)) {
            $json = new JsonResponse($response);

            return $json;
        }

        $params = (1 === (int) $etat);
        call_user_func([$entity, "set{$champs}"], $params);
        $this->manager->persistAndFlush($entity);
        $response['change'] = 1;
        $json               = new JsonResponse($response);

        return $json;
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
