<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Service\DroitService;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user/group")
 */
class GroupController extends LibController
{
    /**
     * @var TableService
     */
    protected $groupManager;

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
        $this->gestionDroit();
        $groupManager = $container->get('bdd.group_manager');
        $breadcrumb   = [
            'libelle' => 'Utilisateur',
            'url'     => 'admin.user.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $this->setTitre('Groupe');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.user.group.index',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($groupManager);
        $this->groupManager = $groupManager;
        $this->crud         = $crud;
    }

        /**
         * Génére les droits pour les groupes
         *
         * @return    void
         */
    public function gestionDroit(): void
    {
        $this->droitService = $this->container->get(DroitService::class);
        $this->droitService->supprimer();
        $manager    = $this->container->get('bdd.group_manager');
        $repository = $manager->getRepository();
        $groups     = $repository->findAll();
        foreach ($groups as $group) {
            if ('superadmin' !== (string) $group->getCode()) {
                $this->droitService->add($group);
            }
        }
    }

    /**
     * @Route("/delete", name="admin.user.group.delete")
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
     * @Route("/", name="admin.user.group.index")
     *
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('id');
        $render = $crudList->render();

        return $render;
    }

    /**
     * @Route("/form/{id}", name="admin.user.group.form", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function form(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormGroup', 'mkk_admin.form.group');
        $crudForm->setTwig('MkkAdminBundle:Group:form.html.twig');
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
        $crud->addShow('code');
        $crud->addShow(
            'totalnbuser',
            [
            'label' => 'Total Utilisateur',
            ]
        );
    }
}
