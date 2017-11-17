<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Service\Traits\PostTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class PostService
{
    use PostTrait;

    const RECAPTCHA_ACCESS = 3;
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Router
     */
    protected $router;

    protected $controller;

    protected $entity;

    protected $etat;

    protected $forms;

    /**
     * @var int
     */
    protected $identifier;
    /**
     * @var bool
     */
    protected $new;

    /**
     * @var ParamService
     */
    protected $paramService;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $reference;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var array
     */
    protected $params;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->requestStack = $container->get('request_stack');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->router       = $container->get('router');
        $this->paramService = $container->get(ParamService::class);
        $this->params       = $this->paramService->listing();
        $this->forms        = [];
        $this->response     = [];
        $this->identifier   = 0;
        $this->new          = FALSE;
    }

    /**
     * Récupére l'identifiant de l'entité.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->identifier;
    }

    /**
     * Vérifie si l'entité est un nouveau code.
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * inialise le post.
     *
     * @param mixed  $entity Class Table
     * @param string $form   Nom du formulaireD
     * @param string $etat   ajouter ou modifier
     *
     * @return void
     */
    public function init($entity, $form, string $etat): void
    {
        $this->entity = $entity;
        if (is_object($form)) {
            $this->forms[] = $form;
        } else {
            $this->forms = $form;
        }

        $this->etat            = $etat;
        $this->response[$etat] = 0;
        $this->initReference();
        if ($this->request->isMethod('POST')) {
            $this->ifContinuer($etat);
        }
    }
}
