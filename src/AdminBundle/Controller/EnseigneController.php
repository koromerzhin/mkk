<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Enseigne\SearchTrait;
use Mkk\AdminBundle\Controller\Enseigne\UploadTrait;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class EnseigneController extends LibController
{
    use SearchTrait;
    use UploadTrait;
    /**
     * @var TableService
     */
    protected $etablissementManager;

    /**
     * @var LibRepository
     */
    protected $repository;

    private $enseigne;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setTitre('Enseigne');
        $this->etablissementManager = $this->container->get('bdd.etablissement_manager');
        $this->repository           = $this->etablissementManager->getRepository();
        $enseigne                   = $this->repository->findOneByType('enseigne');
        if ($enseigne) {
            $this->enseigne = $enseigne;
        }

        $breadcrumb = [
            'libelle' => 'Enseigne',
            'url'     => 'admin.enseigne',
        ];

        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $crud->setManager($this->etablissementManager);
        $this->crud = $crud;
        $this->breadcrumbService->add($breadcrumb);
    }

    /**
     * @Route("/enseigne", name="admin.enseigne")
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormEnseigne', 'mkk_admin.form.enseigne');
        $crudForm->setEntity($this->enseigne);
        $crudForm->setTwig('MkkAdminBundle:Enseigne:index.html.twig');
        $crudForm->disableNewBreadcrumb();
        $response = $crudForm->render();

        return $response;
    }
}
