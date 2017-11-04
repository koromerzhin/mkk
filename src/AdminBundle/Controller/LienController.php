<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Form\LienType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/data/lien")
 */
class LienController extends LibController
{
    /**
     * @var TableService
     */
    protected $lienManager;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->lienManager = $container->get('bdd.lien_manager');
        $this->setTitre('Liens');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.lien.index',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->lienManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/", name="admin.lien.index")
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
     * @Route("/edit/{id}", name="admin.lien.edit", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormLien', LienType::class);
        $crudForm->setTwig('MkkAdminBundle:Data:lien.html.twig');
        $render = $crudForm->render();

        return $render;
    }

    /**
     * @Route("/delete", name="admin.lien.delete")
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
                'url' => 'admin.lien.edit',
            ]
        );
        $crud->addShow('adresse');
    }
}
