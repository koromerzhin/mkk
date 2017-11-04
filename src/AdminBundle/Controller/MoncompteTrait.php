<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Moncompte\UploadTrait;
use Mkk\AdminBundle\Form\ProfilType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudForm;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class MoncompteTrait extends LibController
{
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $userManager;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setTitre('Mon compte');
        $this->userManager = $this->container->get('bdd.user_manager');
        $breadcrumb        = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.profil',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->userManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/moncompte", name="admin.profil")
     * Gestion du profil
     *
     * @return Response
     */
    public function moncompteProfil(): Response
    {
        $crud = $this->crudMonCompte();

        return $crud;
    }

    /**
     * Affichage du formulaire.
     *
     * @return CrudForm
     */
    private function crudMonCompte(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormMonCompte', ProfilType::class);
        $crudForm->setEntity($this->get('security.token_storage')->getToken()->getUser());
        $crudForm->setTwig('MkkAdminBundle:Moncompte:index.html.twig');
        $crudForm->disableNewBreadcrumb();
        $response = $crudForm->render();

        return $response;
    }
}
