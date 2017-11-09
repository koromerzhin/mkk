<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Service\FormService;
use Mkk\SiteBundle\Service\PostService;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class CrudForm
{
    /**
     * @var ContainerInterface
     */
    private $twig;

    /**
     * @var FormService
     */
    private $formService;

    /**
     * @var TableService
     */
    private $manager;

    /**
     * @var LibController
     */
    private $controller;

    /**
     * @var LibRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $etat;

    /**
     * @var array
     */
    private $methods;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     *  @var FlashBag
     */
    private $flashBag;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var bool
     */
    private $disableNewBreadcrumb;

    private $entity;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $form;

    /**
     * @var string
     */
    private $route;

    /**
     * @var ActionService
     */
    private $actionService;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container            = $container;
        $this->etat                 = 'modifier';
        $this->requestStack         = $container->get('request_stack');
        $this->router               = $container->get('router');
        $this->request              = $this->requestStack->getCurrentRequest();
        $this->session              = $this->request->getSession();
        $this->flashBag             = $this->session->getFlashBag();
        $this->formService          = $container->get(FormService::class);
        $this->disableNewBreadcrumb = FALSE;
        $this->actionService        = $this->container->get(ActionService::class);
    }

    /**
     * Set le controller.
     *
     * @param Controller $controller classe par défaut
     *
     * @return void
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Identifie le manager.
     *
     * @param TableService $manager string
     *
     * @return void
     */
    public function setManager(TableService $manager): void
    {
        $this->manager    = $manager;
        $this->repository = $this->manager->getRepository();
    }

    /**
     * Indique si c'est un ajout ou une modification.
     *
     * @return string
     */
    public function getEtat(): string
    {
        return $this->etat;
    }

    /**
     * set le formulaire.
     *
     * @param string $identifiant FormMonCompte
     * @param string $service     FormType ou admin.coordonnees.form
     *
     * @return void
     */
    public function setForm(string $identifiant, $service): void
    {
        $this->form = [
            'id'   => $identifiant,
            'form' => $service,
        ];
    }

    /**
     * Indique la vue a utiliser pour le render.
     *
     * @param string $twig vue.html.twig
     *
     * @return void
     */
    public function setTwig(string $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * Rends le formulaire.
     *
     * @return Response
     */
    public function render(): Response
    {
        $infoRoute   = $this->request->attributes->all();
        $this->route = $this->router->generate($infoRoute['_route'], $infoRoute['_route_params']);
        $this->initEntity();
        $options = [
            'attr' => [
                'id' => $this->form['id'],
            ],
            'action' => $this->route,
        ];
        $this->formService->setEtat($this->etat);
        $this->formService->setManager($this->manager);
        $this->formService->set(
            $this->form['form'],
            $this->entity,
            $options
        );
        if ($this->formService->isRedirect()) {
            $url      = $this->router->generate(str_replace('form', 'index', $infoRoute['_route']));
            $redirect = new RedirectResponse($url);

            return $redirect;
        }

        $postService = $this->container->get(PostService::class);
        $postService->init($this->entity, $this->formService->get(), $this->etat);
        $all = $this->request->request->all();
        if (isset($all['_view']) && '' !== $all['_view']) {
            $redirect = new RedirectResponse($all['_view']);

            return $redirect;
        }

        if ($postService->isNew()) {
            $url = $this->router->generate(
                $infoRoute['_route'],
                [
                    'id' => $postService->getId(),
                ]
            );

            $redirect = new RedirectResponse($url);

            return $redirect;
        }

        $soustitre = $this->entity;
        if ('ajouter' === $this->etat) {
            $soustitre = 'Ajouter';
        }

        $this->controller->setSousTitre($soustitre);
        $form = $this->formService->views();

        $parameters = [
            'form'   => $form,
            'entity' => $this->entity,
            'etat'   => $this->etat,
        ];

        if (!$this->disableNewBreadcrumb) {
            $breadcrumbService = $this->controller->breadcrumbService;
            $listBreadcrumb    = $breadcrumbService->get();
            $last              = end($listBreadcrumb);
            $this->actionService->addBtnReturn($last['url']);
            $breadcrumb = [
                'libelle' => 'Formulaire',
                'url'     => $infoRoute['_route'],
                'params'  => $infoRoute['_route_params'],
            ];
            $breadcrumbService->add($breadcrumb);
        }

        $this->actionService->addBtnSave($this->form['id']);
        $render = $this->controller->render($this->twig, $parameters);

        return $render;
    }

    /**
     * Desactive le dernier breadcrumb.
     *
     * @return void
     */
    public function disableNewBreadcrumb(): void
    {
        $this->disableNewBreadcrumb = TRUE;
    }

    /**
     * Set entity.
     *
     * @param string $entity Mkk\SiteBundle\Entity\Blog par exemple
     *
     * @return void
     */
    public function setEntity($entity): void
    {
        $this->entity  = $entity;
        $this->methods = get_class_methods($entity);
    }

    /**
     * Initialise l'entité.
     *
     * @return void
     */
    private function initEntity(): void
    {
        if (isset($this->entity)) {
            return;
        }

        $infoRoute = $this->request->attributes->all();
        $entity    = $this->repository->findoneBy($infoRoute['_route_params']);
        if (!$entity) {
            $this->etat    = 'ajouter';
            $table         = $this->manager->getTable();
            $entity        = new $table();
            $this->methods = get_class_methods($entity);
        } else {
            $this->methods = get_class_methods($entity);
            if (in_array('setTranslatableLocale', $this->methods)) {
                $entity->setTranslatableLocale($this->request->getLocale());
                $this->manager->refresh($entity);
            }
        }

        $this->entity = $entity;
    }
}
