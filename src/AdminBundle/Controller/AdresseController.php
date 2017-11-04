<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Form\AdresseType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/data/adresse")
 */
class AdresseController extends LibController
{
    /**
     * @var TableService
     */
    protected $adresseManager;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->adresseManager = $container->get('bdd.adresse_manager');
        $this->setTitre('Adresse');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.adresse.index',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->adresseManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/", name="admin.adresse.index")
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
     * @Route("/edit/{id}", name="admin.adresse.edit", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function edit(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormAdresse', AdresseType::class);
        $crudForm->setTwig('MkkAdminBundle:Data:adresse.html.twig');
        $render = $crudForm->render();

        return $render;
    }

    /**
     * @Route("/delete", name="admin.adresse.delete")
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
            'info',
            [
                'url' => 'admin.adresse.edit',
            ]
        );
        $crud->addShow(
            'cp',
            [
                'label' => 'Code postal',
            ]
        );
        $crud->addShow('ville');
        $crud->addShow('pays');
    }
}
