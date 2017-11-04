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

class CrudEmpty
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LibRepository
     */
    private $repository;

    /**
     * @var TableService
     */
    private $manager;

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
     * @var string
     */
    private $table;

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
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        $response  = [];
        $container = $this->container;
        $entity    = $this->table;
        if ($container->has("bdd.{$entity}_manager")) {
            $tableManager    = $container->get("bdd.{$entity}_manager");
            $tableRepository = $tableManager->getRepository();
            $batchSize       = 25;
            $response        = ['vider' => 1];
            set_time_limit(0);
            $entities = $tableRepository->findall();
            foreach ($entities as $i => $entity) {
                $tableManager->remove($entity);
                if (0 === ($i % $batchSize)) {
                    $tableManager->flush();
                }
            }

            $tableManager->flush();
        }

        $json = new JsonResponse($response);

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
