<?php

namespace Mkk\AdminBundle\Lib;

use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Lib\LibController as MkkSiteLibController;
use Mkk\SiteBundle\Service\BreadCrumbService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class LibController extends MkkSiteLibController
{
    /**
     * @var BreadCrumbService
     */
    public $breadcrumbService;

    /**
     * @var string
     */
    protected $titre;

    /**
     * @var string
     */
    protected $soustitre;

    /**
     * @var mixed
     */
    protected $paramViews;

    /**
     * @var Crud
     */
    protected $crud;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $breadcrumb = [
            'libelle' => 'Dashboard',
            'url'     => 'admin.index',
        ];

        $this->getMenu();
        $this->breadcrumbService->add($breadcrumb);
        $this->crud = $container->get(Crud::class);
    }

    /**
     * Get Crud.
     *
     * @return Crud
     */
    public function getCrud(): Crud
    {
        $crud = $this->crud;
        $crud->setController($this);

        return $crud;
    }

    /**
     * Recrer le render().
     *
     * @param string   $view       view.html.twig
     * @param array    $parameters view.html.twig
     * @param Response $response   euh..
     *
     * @return Response
     */
    public function render($view, array $parameters = [], ?Response $response = NULL): Response
    {
        $this->addParamViewsAdmin($parameters);

        $render = parent::render($view, $this->paramViews, $response);

        return $render;
    }

    /**
     * Set titre.
     *
     * @param string $titre string
     *
     * @return void
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * Set sous titre.
     *
     * @param string $soustitre string
     *
     * @return void
     */
    public function setSousTitre(string $soustitre): void
    {
        $this->soustitre = $soustitre;
    }

    /**
     * Get the value of Titre.
     *
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Get the value of Soustitre.
     *
     * @return string
     */
    public function getSoustitre(): string
    {
        return $this->soustitre;
    }

    /**
     * Ajoute les parameters a twig.
     *
     * @param array $parameters array
     *
     * @return void
     */
    protected function addParamViewsAdmin(array $parameters): void
    {
        $this->paramViews['adminHeader']['titre']  = is_string($this->titre) ? $this->titre : '';
        $this->paramViews['adminHeader']['stitre'] = is_string($this->soustitre) ? $this->soustitre : '';
        $this->addActions();
        $this->paramViews = array_merge($this->paramViews, $parameters);
    }

    /**
     * Génére le menu.
     *
     * @return void
     */
    private function getMenu(): void
    {
        $menus      = [];
        $servicesID = $this->container->getServiceIds();
        foreach ($servicesID as $service) {
            if (0 !== substr_count($service, "AdminBundle\Menu")) {
                $menu  = $this->container->get($service);
                $menus = $menu->get($menus);
            }
        }

        $this->paramViews['menusAdmin'] = $menus;
    }

    /**
     * Ajoute les actions à twig.
     *
     * @return void
     */
    private function addActions(): void
    {
        $actionsService              = $this->container->get(ActionService::class);
        $actions                     = $actionsService->get();
        $this->paramViews['actions'] = $actions;
    }
}
