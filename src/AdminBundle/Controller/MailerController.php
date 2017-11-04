<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/data/mailer")
 */
class MailerController extends LibController
{
    /**
     * @var TableService
     */
    protected $mailerManager;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->mailerManager = $container->get('bdd.mailer_manager');
        $this->setTitre('Mailer');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.mailer.index',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->mailerManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/", name="admin.mailer.index")
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('position');
        $render = $crudList->render();

        return $render;
    }

    /**
     * @Route("/delete", name="admin.mailer.delete")
     *
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $crudDelete = $this->crud->getDelete();
        $render     = $crudDelete->render();

        return $render;
    }

    /**
     * @Route("/show/{id}", name="admin.mailer.show")
     *
     * @return Response
     */
    public function show(): Response
    {
        $crudDelete = $this->crud->getShow();
        $render     = $crudDelete->render();

        return $render;
    }

    /**
     * Dis les champs à afficher.
     *
     * @param CrudList $crud Formulaire crud
     *
     * @return void
     */
    public function listCrud(CrudList $crud): void
    {
        $crud->addShowIdentifier(
            'subject',
            [
                'label' => 'Sujet',
                'url'   => 'admin.mailer.show',
            ]
        );
        $crud->addShow('from');
        $crud->addShow('to');
        $crud->addShow('reply');
        $crud->addShow('cc');
        $crud->addShow(
            'dateEnregistrement',
            [
                'label' => "Date d'enregistrement",
            ]
        );
    }
}
