<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Form\SeoType;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/seo")
 */
class SeoController extends LibController
{
    /**
     * @var TableService
     */
    protected $seoManager;

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
        $seoManager = $container->get('bdd.metariane_manager');
        $this->setTitre('Seo');
        $breadcrumb = [
            'libelle' => $this->getTitre(),
            'url'     => 'admin.seo.index',
        ];

        $this->breadcrumbService->add($breadcrumb);
        $crud = $this->getCrud();
        $crud->setManager($seoManager);
        $this->seoManager = $seoManager;
        $this->crud       = $crud;
    }

    /**
     * @Route("/", name="admin.seo.index")
     *
     * Action index
     *
     * @return Response
     */
    public function index(): Response
    {
        $crudList = $this->crud->getList();

        $crudList->setDefaultSort('route');
        $render = $crudList->render();

        return $render;
    }

    /**
     * @Route("/edit/{id}", name="admin.seo.edit", defaults={"id": 0})
     * Action du formulaire
     *
     * @return Response
     */
    public function edit(): Response
    {
        $crudForm = $this->crud->getForm();
        $crudForm->setForm('FormSeo', SeoType::class);
        $crudForm->setTwig('MkkAdminBundle:Seo:form.html.twig');
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
        $crud->addShowIdentifier(
            'route',
            [
                            'url' => 'admin.seo.edit',
                    ]
        );
        $crud->addShow('titre');
        $crud->addShow('description');
        $crud->addShow('keywords');
    }
}
