<?php

namespace Mkk\AdminBundle\Lib;

use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Service\ParamService;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

abstract class LibParamController extends LibController
{
    /**
     * @var TableService
     */
    protected $adresseManager;

    /**
     * @var array
     */
    protected $form;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var ParamService
     */
    protected $paramService;

    /**
     * @var ActionService
     */
    private $actionService;

    /**
     * @var Router
     */
    private $router;

    /**
     * Constructeur.
     *
     * @param ContainerInterface $container Container pour gérer les DI
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->formFactory  = $container->get('form.factory');
        $paramService       = $container->get(ParamService::class);
        $this->paramService = $paramService;
        $this->params       = $paramService->listing();
        $this->router       = $container->get('router');
        $this->setTitre('Param');
        $breadcrumb = [
        'libelle' => $this->getTitre(),
        ];
        $this->breadcrumbService->add($breadcrumb);
        $this->container = $container;
        $crud            = $this->container->get(Crud::class);
        $crud->setController($this);
        $this->crud          = $crud;
        $this->actionService = $this->container->get(ActionService::class);
    }

    /**
     * set le formulaire.
     *
     * @param string $identifiant FormMonCompte
     * @param string $service     FormType ou admin.coordonnees.form
     *
     * @return void
     */
    protected function setForm(string $identifiant, $service): void
    {
        $this->form = [
        'id'   => $identifiant,
        'form' => $service,
        ];
    }

    /**
     * Génére la vue.
     *
     * @param string $libelle Libelle de la vue
     * @param string $twig    url de la vue
     *
     * @return Response
     */
    protected function generate(string $libelle, string $twig): Response
    {
        $infoRoute  = $this->request->attributes->all();
        $breadcrumb = [
        'libelle' => $libelle,
        'url'     => $infoRoute['_route'],
        ];
        $this->setSousTitre($libelle);
        $this->breadcrumbService->add($breadcrumb);
        $options = [
        'attr' => [
            'action' => $this->router->generate($infoRoute['_route'], $infoRoute['_route_params']),
            'id'     => $this->form['id'],
        ],
        ];

        $form = $this->formFactory->create(
            $this->form['form'],
            $this->params,
            $options
        );

        $this->actionService->addBtnSave($this->form['id']);
        if ($this->request->isMethod('POST')) {
            $flashBag = $this->request->getSession()->getFlashBag();
            $flashBag->add('success', 'Sauvegarde des données');
            $params = $this->request->request->get('param');
            foreach ($params as $id => $val) {
                $this->paramService->save($id, $val);
            }
        }

        $all = $this->request->request->all();
        if (isset($all['_view']) && '' !== $all['_view']) {
            $redirect = new RedirectResponse($all['_view']);

            return $redirect;
        }

        $render = $this->render(
            $twig,
            [
            'form' => $form->createView(),
            ]
        );

        return $render;
    }
}
