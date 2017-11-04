<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Form\TelephoneType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/etablissement")
 */
class EtablissementController extends LibController
{
    /**
     * @var TableService
     */
    protected $etablissementManager;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->etablissementManager = $container->get('bdd.etablissement_manager');
        $this->setTitre('Etablissement');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.etablissement.index',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->etablissementManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/new", name="admin.etablissement.new")
     *
     * @return Response
     */
    public function new(): Response
    {
    }

    /**
     * @Route("/", name="admin.etablissement.index")
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('position');
        $crudList->disableForm();
        $actionService = $crudList->getActionService();
        $actions       = [
            'id'   => 'BoutonNewEtablissement',
            'text' => 'Ajouter',
            'url'  => 'admin.etablissement.new',
        ];
        $actionService->add($actions);
        $render = $crudList->render();

        return $render;
    }

    /**
     * @Route("/form/{id}", name="admin.etablissement.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormEtablissement', TelephoneType::class);
        $crudForm->setTwig('MkkAdminBundle:Etablissement:form.html.twig');
        $render = $crudForm->render();

        return $render;
    }

    /**
     * @Route("/delete", name="admin.etablissement.delete")
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
     * Dis les champs à afficher.
     *
     * @param CrudList $crud Formulaire crud
     *
     * @return void
     */
    public function listCrud(CrudList $crud): void
    {
        $crud->addShowIdentifier('nom');
        $crud->addShow('accueil');
        $crud->addShow('actif');
        $crud->addShow(
            'adresses',
            [
                'html' => 'MkkAdminBundle:Crud:tmpl/adresses.html.twig',
            ]
        );
        $crud->addShow(
            'telephones',
            [
                'html' => 'MkkAdminBundle:Crud:tmpl/telephones.html.twig',
            ]
        );
        $crud->addShow(
            'emails',
            [
                'html' => 'MkkAdminBundle:Crud:tmpl/emails.html.twig',
            ]
        );
    }
}
