<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\User\SearchTrait;
use Mkk\AdminBundle\Controller\User\UploadTrait;
use Mkk\AdminBundle\Form\UserType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 */
class UserController extends LibController
{
    use UploadTrait;
    use SearchTrait;
    /**
     * @var TableService
     */
    protected $userManager;

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
        $userManager = $container->get('bdd.user_manager');
        $this->setTitre('Utilisateur');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.user.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($userManager);
        $this->userManager = $userManager;
        $this->crud        = $crud;
    }

    /**
     * @Route("/delete", name="admin.user.delete")
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
     * @Route("/vider", name="admin.user.vider")
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
     * @Route("/", name="admin.user.index")
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
            'type' => 'user',
        ];
        $render = $crudList->render($params);

        return $render;
    }

    /**
     * @Route("/form/{id}", name="admin.user.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormBookmark', UserType::class);
        $crudForm->setTwig('MkkAdminBundle:User:form.html.twig');
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
        $crud->addShowIdentifier('username');
        $crud->addShow('nom');
        $crud->addShow('prenom');
        $crud->addShow(
            'refGroup',
            [
                'label' => 'Groupe',
            ]
        );
        $crud->addShow('avatar');
        $crud->addShow(
            'dateinscription',
            [
                'label' => "Date d'enregistrement",
            ]
        );
        $crud->addShow(
            'lastLogin',
            [
                'label' => 'Dernière connexion',
            ]
        );
    }
}
