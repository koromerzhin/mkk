<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Evenement\SearchTrait;
use Mkk\AdminBundle\Controller\Evenement\UploadTrait;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/evenement")
 */
class EvenementController extends LibController
{
    use SearchTrait;
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $evenementManager;

    /**
     * @var Crud
     */
    protected $crud;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $evenementManager = $container->get('bdd.evenement_manager');
        $this->setTitre('Evenement');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.evenement.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($evenementManager);
        $this->evenementManager = $evenementManager;
        $this->crud             = $crud;
    }

    /**
     * @Route("/delete", name="admin.evenement.delete")
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
     * @Route("/vider", name="admin.evenement.vider")
     *
     * @return JsonResponse
     */
    public function vider(): JsonResponse
    {
        $crudEmpty = $this->crud->getEmpty();
        $render    = $crudEmpty->render();

        return $render;
    }

    /**
     * @Route("/", name="admin.evenement.index")
     *
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
     * @Route("/form/{id}", name="admin.evenement.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormEvenement', 'mkk_admin.form.evenement');
        $crudForm->setTwig('MkkAdminBundle:Evenement:form.html.twig');
        $render = $crudForm->render();

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
        $crud->addShowIdentifier('titre');
        $crud->addShow('description');
        $crud->addShow('url');
        $crud->addShow('image');
        $crud->addShow('type');
        $crud->addShow('placeillimite');
        $crud->addShow('externe');
        $crud->addShow('validation');
        $crud->addShow('correction');
        $crud->addShow('publier');
    }
}
