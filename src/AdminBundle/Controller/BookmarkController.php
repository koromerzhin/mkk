<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Bookmark\UploadTrait;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/bookmark")
 */
class BookmarkController extends LibController
{
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $bookmarkManager;

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
        $bookmarkManager = $container->get('bdd.bookmark_manager');
        $this->setTitre('Bookmark');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.bookmark.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($bookmarkManager);
        $this->bookmarkManager = $bookmarkManager;
        $this->crud            = $crud;
    }

    /**
     * @Route("/delete", name="admin.bookmark.delete")
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
     * @Route("/vider", name="admin.bookmark.vider")
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
     * @Route("/", name="admin.bookmark.index")
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
     * @Route("/form/{id}", name="admin.bookmark.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormBookmark', 'mkk_admin.form.bookmark');
        $crudForm->setTwig('MkkAdminBundle:Bookmark:form.html.twig');
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
