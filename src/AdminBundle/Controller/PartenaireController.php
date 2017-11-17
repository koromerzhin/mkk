<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Partenaire\SearchTrait;
use Mkk\AdminBundle\Controller\Partenaire\UploadTrait;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/partenaire")
 */
class PartenaireController extends LibController
{
    use SearchTrait;
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $partenaireManager;

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
        $partenaireManager = $container->get('bdd.partenaire_manager');
        $this->setTitre('Partenaire');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.partenaire.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($partenaireManager);
        $this->partenaireManager = $partenaireManager;
        $this->crud              = $crud;
    }

    /**
     * @Route("/delete", name="admin.partenaire.delete")
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
     * @Route("/vider", name="admin.partenaire.vider")
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
     * @Route("/", name="admin.partenaire.index")
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
     * @Route("/form/{id}", name="admin.partenaire.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormPartenaire', 'mkk_admin.form.partenaire');
        $crudForm->setTwig('MkkAdminBundle:Partenaire:form.html.twig');
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
        $crud->addShow('description');
        $crud->addShow('slogan');
        $crud->addShow('url');
        $crud->addShow('image');
        $crud->addShow(
            'actifpublic',
            [
                'label' => 'Actif',
            ]
        );
        $crud->addShow('position');
    }
}
