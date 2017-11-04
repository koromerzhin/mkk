<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Form\TagType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/data/blog/tag")
 */
class BlogTagController extends LibController
{
    /**
     * @var TableService
     */
    protected $tagManager;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->tagManager = $container->get('bdd.tag_manager');
        $this->setTitre('Tag');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.blog.tag.index',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->tagManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/", name="admin.blog.tag.index")
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('position');
        $params = [
            'type' => 'blog',
        ];
        $render = $crudList->render($params);

        return $render;
    }

    /**
     * @Route("/edit/{id}", name="admin.blog.tag.edit", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormTag', TagType::class);
        $crudForm->setTwig('MkkAdminBundle:Data:tag.html.twig');
        $render = $crudForm->render();

        return $render;
    }

    /**
     * @Route("/delete", name="admin.blog.tag.delete")
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
        $crud->addShowIdentifier(
            'nom',
            [
                'url' => 'admin.blog.tag.edit',
            ]
        );
        $crud->addShow('alias');
        $crud->addShow(
            'totalnbblog',
            [
                'label' => 'Total Blog',
            ]
        );
    }
}
