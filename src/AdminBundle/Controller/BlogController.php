<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Blog\SearchTrait;
use Mkk\AdminBundle\Controller\Blog\UploadTrait;
use Mkk\AdminBundle\Form\BlogType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/blog")
 */
class BlogController extends LibController
{
    use SearchTrait;
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $blogManager;

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
        $blogManager = $container->get('bdd.blog_manager');
        $this->setTitre('Blog');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.blog.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($blogManager);
        $this->blogManager = $blogManager;
        $this->crud        = $crud;
    }

    /**
     * @Route("/delete", name="admin.blog.delete")
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
     * @Route("/vider", name="admin.blog.vider")
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
     * @Route("/", name="admin.blog.index")
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
     * @Route("/form/{id}", name="admin.blog.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormBlog', BlogType::class);
        $crudForm->setTwig('MkkAdminBundle:Blog:form.html.twig');
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
        $crud->addShow(
            'refcategorie',
            [
                'label' => 'Categorie',
            ]
        );
        $crud->addShow(
            'datemodif',
            [
                'label' => 'Date de modification',
            ]
        );
        $crud->addShow(
            'datepublication',
            [
                'label' => 'Date de publication',
            ]
        );
        $crud->addShow(
            'langue'
        );
        $crud->addShow(
            'actifpublic',
            [
                'label' => 'Actif',
            ]
        );
        $crud->addShow(
            'avant',
            [
                'label' => 'Mettre en avant',
            ]
        );
        $crud->addShow(
            'redacteur',
            [
                'label' => 'Affichage du rédacteur',
            ]
        );
        $crud->addShow(
            'accueil',
            [
                'label' => "Mettre sur la page d'accueil",
            ]
        );
        $crud->addShow('code');
    }
}
