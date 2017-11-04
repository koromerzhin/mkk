<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Contact\SearchTrait;
use Mkk\AdminBundle\Form\ContactType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/contact")
 */
class ContactController extends LibController
{
    use SearchTrait;
    /**
     * @var TableService
     */
    protected $contactManager;

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
        $contactManager = $container->get('bdd.user_manager');
        $this->setTitre('Contact');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.contact.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($contactManager);
        $this->contactManager = $contactManager;
        $this->crud           = $crud;
    }

    /**
     * @Route("/delete", name="admin.contact.delete")
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
     * @Route("/vider", name="admin.contact.vider")
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
     * @Route("/", name="admin.contact.index")
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
            'type' => 'contact',
        ];
        $render = $crudList->render($params);

        return $render;
    }

    /**
     * @Route("/form/{id}", name="admin.contact.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormContact', ContactType::class);
        $crudForm->setTwig('MkkAdminBundle:Contact:form.html.twig');
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
        $crud->addShow('prenom');
        $crud->addShow(
            'refGroup',
            [
                'label' => 'Groupe',
            ]
        );
        $crud->addShow(
            'dateinscription',
            [
                'label' => "Date d'enregistrement",
            ]
        );
    }
}
