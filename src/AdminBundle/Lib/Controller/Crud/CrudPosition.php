<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class CrudPosition
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ActionService
     */
    private $actionService;

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
        $this->container     = $container;
        $this->requestStack  = $container->get('request_stack');
        $this->router        = $container->get('router');
        $this->request       = $this->requestStack->getCurrentRequest();
        $this->actionService = $this->container->get(ActionService::class);
        $this->session       = $this->request->getSession();
        $this->flashBag      = $this->session->getFlashBag();
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
        if ($this->request->isMethod('POST')) {
            $this->flashBag->add('success', 'Sauvegarde des positions effectués');
            $json      = [];
            $position  = $this->request->request->get('position');
            $batchSize = 5;
            $j         = 0;
            foreach ($position as $row) {
                $list = explode(',', $row);
                $i    = 0;
                foreach ($list as $id) {
                    ++$i;
                    $entity = $this->repository->find($id);
                    if ($entity) {
                        $entity->setPosition($i);
                        $this->manager->persist($entity);
                    }

                    if (0 === ($j % $batchSize)) {
                        $this->manager->flush();
                    }

                    ++$j;
                }
            }

            $return = new JsonResponse($json);

            return $return;
        }

        $infoRoute         = $this->request->attributes->all();
        $breadcrumbService = $this->controller->breadcrumbService;
        $results           = $this->repository->searchPosition();
        $breadcrumb        = [
            'libelle' => 'Position',
            'url'     => $infoRoute['_route'],
        ];
        $breadcrumbService->add($breadcrumb);
        $actions = [
            'id'   => 'BoutonSave',
            'text' => 'Enregistrer',
            'url'  => $infoRoute['_route'],
        ];
        $this->actionService->add($actions);
        $actions = [
            'id'   => 'BoutonSaveAndClose',
            'text' => 'Enregistrer et fermer',
            'img'  => 'glyphicon glyphicon-save',
        ];
        $this->actionService->add($actions);
        $this->controller->setSousTitre('Position');
        $render = $this->controller->render(
            'MkkAdminBundle:Position:index.html.twig',
            [
                'results' => $results,
            ]
        );

        return $render;
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
        $this->repository = $manager->getRepository();
    }
}
