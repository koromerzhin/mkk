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
 * @Route("/partenaire/categorie")
 */
class PartenaireCategorieController extends LibController
{
    /**
     * @var TableService
     */
    protected $categorieManager;

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
        $categorieManager = $container->get('bdd.categorie_manager');
        $breadcrumb       = [
            'libelle' => 'Partenaire',
            'url'     => 'admin.partenaire.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $this->setTitre('Catégorie');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.partenaire.categorie.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($categorieManager);
        $this->categorieManager = $categorieManager;
        $this->crud             = $crud;
    }

    /**
     * @Route("/delete", name="admin.categorie.delete")
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
     * @Route("/vider", name="admin.categorie.vider")
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
     * @Route("/", name="admin.partenaire.categorie.index")
     *
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('position');
        $params = [
            'type' => 'partenaire',
        ];
        $render = $crudList->render($params);

        return $render;
    }

    /**
     * @Route("/form/{id}", name="admin.partenaire.categorie.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormCategorie', 'mkk_admin.form.categorie');
        $crudForm->setTwig('MkkAdminBundle:Categorie:form.html.twig');
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
        $crud->addShow('actif');
        $crud->addShow(
            'totalnbpartenaire',
            [
                'label' => 'Total partenaire',
            ]
        );
    }
}
