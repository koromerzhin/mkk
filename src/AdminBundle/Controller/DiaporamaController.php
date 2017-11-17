<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Diaporama\UploadTrait;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/diaporama")
 */
class DiaporamaController extends LibController
{
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $diaporamaManager;

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
        $diaporamaManager = $container->get('bdd.diaporama_manager');
        $this->setTitre('Diaporama');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.diaporama.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($diaporamaManager);
        $this->diaporamaManager = $diaporamaManager;
        $this->crud             = $crud;
    }

    /**
     * @Route("/delete", name="admin.diaporama.delete")
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
     * @Route("/vider", name="admin.diaporama.vider")
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
     * @Route("/", name="admin.diaporama.index")
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
     * @Route("/form/{id}", name="admin.diaporama.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormDiaporama', 'mkk_admin.form.diaporama');
        $crudForm->setTwig('MkkAdminBundle:Diaporama:form.html.twig');
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
    }
}
