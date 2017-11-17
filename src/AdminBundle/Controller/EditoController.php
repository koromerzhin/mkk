<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Edito\SearchTrait;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/edito")
 */
class EditoController extends LibController
{
    use SearchTrait;
    /**
     * @var TableService
     */
    protected $editoManager;

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
        $editoManager = $container->get('bdd.edito_manager');
        $this->setTitre('Editorial');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.edito.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($editoManager);
        $this->editoManager = $editoManager;
        $this->crud         = $crud;
    }

    /**
     * @Route("/delete", name="admin.edito.delete")
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
     * @Route("/vider", name="admin.edito.vider")
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
     * @Route("/", name="admin.edito.index")
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
     * @Route("/form/{id}", name="admin.edito.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormEdito', 'mkk_admin.form.edito');
        $crudForm->setTwig('MkkAdminBundle:Edito:form.html.twig');
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
        $crud->addShowIdentifier('nom');
        $crud->addShow('type');
        $crud->addShow('publier');
        $crud->addShow('code');
    }
}
