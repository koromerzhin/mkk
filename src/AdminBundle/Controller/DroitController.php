<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Service\DroitService;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

/**
 * @Route("/droit")
 */
class DroitController extends LibController
{
    /**
     * @var TableService
     */
    protected $blogManager;

    /**
     * @var Crud
     */
    protected $crud;

    /**
     * @var Router
     */
    private $router;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $blogManager  = $container->get('bdd.action_manager');
        $this->router = $container->get('router');
        $this->setTitre('Droit');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.droit.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($blogManager);
        $this->blogManager = $blogManager;
        $this->crud        = $crud;
    }

    /**
     * @Route("/actif", name="admin.droit.actif")
     *
     * Action index
     *
     * @return Response
     */
    public function actif(): Response
    {
        $crudBoolean = $this->crud->getBoolean();
        $render      = $crudBoolean->render('etat');

        return $render;
    }

    /**
     * @Route("/", name="admin.droit.index")
     *
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $pattern    = $this->get(DroitService::class)->getRoute();
        $crudList   = $this->crud->getList();
        $manager    = $this->get('bdd.group_manager');
        $repository = $manager->getRepository();
        $groups     = $repository->findAll();
        $manager    = $this->get('bdd.action_manager');
        $repository = $manager->getRepository();
        $actions    = $repository->findAll();
        $routes     = [];
        foreach ($actions as $action) {
            $route = $action->getRoute();
            $group = $action->getRefGroup();
            $etat  = $action->isEtat();
            $code  = $group->getCode();
            if ('superadmin' !== $code) {
                $id = $action->getId();
                if (!isset($routes[$route])) {
                    $routes[$route] = [];
                }

                $routes[$route][$code] = [
                    'etat' => $etat,
                    'id'   => $id,
                ];
            }
        }

        $crudList->setDefaultSort('route');
        $render = $this->render(
            'MkkAdminBundle:Droit:index.html.twig',
            [
                    'pattern' => $pattern,
                    'routes'  => $routes,
                    'groups'  => $groups,
                ]
        );

        return $render;
    }
}
