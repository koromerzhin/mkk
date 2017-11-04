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

class CrudDelete
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
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        $response = [];
        $request  = $this->request;
        set_time_limit(0);
        $post['id']        = $request->request->get('id');
        $post['selection'] = $request->request->get('selection');
        $response          = ['supprimer' => 0];
        try {
            $response = $this->tryDelete($post, $response);
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();

            $response['supprimer'] = 2;
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

    /**
     * Essaye de supprimer une ligne d'une table.
     *
     * @param mixed $post         POST
     * @param mixed $responsejson Json
     *
     * @return array
     *
     * @author
     * @copyright
     */
    private function tryDelete($post, array $responsejson): array
    {
        $tableRepository = $this->manager->getRepository();
        set_time_limit(0);
        $batchSize = 5;
        if ('' !== $post['id']) {
            $selection = [$post['id']];
        } elseif ('' !== $post['selection']) {
            $selection = explode(',', $post['selection']);
        }

        $i = 0;
        foreach ($selection as $id) {
            $data = $tableRepository->find($id);
            if ($data) {
                ++$i;
                $responsejson['supprimer'] = 1;
                $this->manager->remove($data);
                if (0 === ($i % $batchSize)) {
                    $this->manager->flush();
                }
            }
        }

        $this->manager->flush();

        return $responsejson;
    }
}
