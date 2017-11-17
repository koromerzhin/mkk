<?php

namespace Mkk\SiteBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class BreadCrumbService
{
    /**
     * @var Request
     */
    protected $request;

    protected $controller;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private $tab;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $params          = $container->get(ParamService::class);
        $this->params    = $params->listing();
        $this->session   = $container->get('session');
        $requestStack    = $container->get('request_stack');
        $this->request   = $requestStack->getCurrentRequest();
        $this->tab       = [];
    }

    /**
     * Ajouter le breadcrumb.
     *
     * @param array $tab un breadcrumb
     *
     * @return void
     */
    public function set(array $tab): void
    {
        $this->tab = $tab;
    }

    /**
     * Ajouter un lien dans le breadcrumb.
     *
     * @param array $tab un lien
     *
     * @return void
     */
    public function add(array $tab): void
    {
        $this->tab[] = $tab;
    }

    /**
     * Récupère les breadcrumb.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->tab;
    }
}
