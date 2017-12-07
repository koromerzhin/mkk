<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Controller\Param\SearchTrait;
use Mkk\AdminBundle\Controller\Param\UploadTrait;
use Mkk\AdminBundle\Form\Param\ApiType;
use Mkk\AdminBundle\Form\Param\BddType;
use Mkk\AdminBundle\Form\Param\BlogType;
use Mkk\AdminBundle\Form\Param\EtablissementType;
use Mkk\AdminBundle\Form\Param\EvenementType;
use Mkk\AdminBundle\Form\Param\InterfaceType;
use Mkk\AdminBundle\Form\Param\ListingType;
use Mkk\AdminBundle\Form\Param\LoginType;
use Mkk\AdminBundle\Form\Param\MediaType;
use Mkk\AdminBundle\Form\Param\RobotstxtType;
use Mkk\AdminBundle\Form\Param\SiteType;
use Mkk\AdminBundle\Form\Param\TableaubordType;
use Mkk\AdminBundle\Form\Param\TagType;
use Mkk\AdminBundle\Form\Param\TinymceType;
use Mkk\AdminBundle\Form\Param\UploadType;
use Mkk\AdminBundle\Form\Param\WidgetType;
use Mkk\AdminBundle\Lib\Crud;
use Mkk\AdminBundle\Lib\LibParamController;
use Mkk\AdminBundle\Service\ActionService;
use Mkk\SiteBundle\Service\ParamService;
use Mkk\SiteBundle\Table\TableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

/**
 * @Route("/param")
 */
class ParamController extends LibParamController
{
    use SearchTrait;
    use UploadTrait;
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
     * @Route("/etablissement", name="admin.param.etablissement")
     * Action du formulaire
     *
     * @return Response
     */
    public function etablissement(): Response
    {
        $this->setForm('FormParamEtablissement', EtablissementType::class);
        $render = $this->generate('Etablissement', 'MkkAdminBundle:Param:etablissement.html.twig');

        return $render;
    }

    /**
     * @Route("/upload", name="admin.param.upload")
     * Action du formulaire
     *
     * @return Response
     */
    public function upload(): Response
    {
        $this->setForm('FormParamUpload', UploadType::class);
        $render = $this->generate('Upload', 'MkkAdminBundle:Param:upload.html.twig');

        return $render;
    }

    /**
     * @Route("/api", name="admin.param.api")
     * Action du formulaire
     *
     * @return Response
     */
    public function api(): Response
    {
        $this->setForm('FormParamApi', ApiType::class);
        $render = $this->generate('Api', 'MkkAdminBundle:Param:api.html.twig');

        return $render;
    }

    /**
     * @Route("/blog", name="admin.param.blog")
     * Action du formulaire
     *
     * @return Response
     */
    public function blog(): Response
    {
        $this->setForm('FormParamBlog', BlogType::class);
        $render = $this->generate('Blog', 'MkkAdminBundle:Param:blog.html.twig');

        return $render;
    }

    /**
     * @Route("/bdd", name="admin.param.bdd")
     * Action du formulaire
     *
     * @return Response
     */
    public function bdd(): Response
    {
        $this->setForm('FormParamBdd', BddType::class);
        $render = $this->generate('Base de données', 'MkkAdminBundle:Param:bdd.html.twig');

        return $render;
    }

    /**
     * @Route("/evenement", name="admin.param.evenement")
     * Action du formulaire
     *
     * @return Response
     */
    public function evenement(): Response
    {
        $this->setForm('FormParamEvenement', EvenementType::class);
        $render = $this->generate('Evènement', 'MkkAdminBundle:Param:evenement.html.twig');

        return $render;
    }

    /**
     * @Route("/interface", name="admin.param.interface")
     * Action du formulaire
     *
     * @return Response
     */
    public function interface(): Response
    {
        $this->setForm('FormParamInterface', InterfaceType::class);
        $render = $this->generate('Interface', 'MkkAdminBundle:Param:interface.html.twig');

        return $render;
    }

    /**
     * @Route("/listing", name="admin.param.listing")
     * Action du formulaire
     *
     * @return Response
     */
    public function listing(): Response
    {
        $this->setForm('FormParamListing', ListingType::class);
        $render = $this->generate('Listing', 'MkkAdminBundle:Param:listing.html.twig');

        return $render;
    }

    /**
     * @Route("/login", name="admin.param.login")
     * Action du formulaire
     *
     * @return Response
     */
    public function login(): Response
    {
        $this->setForm('FormParamLogin', LoginType::class);
        $render = $this->generate('Login', 'MkkAdminBundle:Param:login.html.twig');

        return $render;
    }

    /**
     * @Route("/site", name="admin.param.site")
     * Action du formulaire
     *
     * @return Response
     */
    public function site(): Response
    {
        $this->setForm('FormParamSite', SiteType::class);
        $render = $this->generate('Site', 'MkkAdminBundle:Param:site.html.twig');

        return $render;
    }

    /**
     * @Route("/tableaubord", name="admin.param.tableaubord")
     * Action du formulaire
     *
     * @return Response
     */
    public function tableaubord(): Response
    {
        $this->setForm('FormParamTableauBord', TableaubordType::class);
        $render = $this->generate('Tableau de bord', 'MkkAdminBundle:Param:tableaubord.html.twig');

        return $render;
    }

    /**
     * @Route("/tag", name="admin.param.tag")
     * Action du formulaire
     *
     * @return Response
     */
    public function tag(): Response
    {
        $this->setForm('FormParamTag', TagType::class);
        $render = $this->generate('Tag', 'MkkAdminBundle:Param:tag.html.twig');

        return $render;
    }

    /**
     * @Route("/widget", name="admin.param.widget")
     * Action du formulaire
     *
     * @return Response
     */
    public function widget(): Response
    {
        $this->setForm('FormParamWidget', WidgetType::class);
        $render = $this->generate('Widget', 'MkkAdminBundle:Param:widget.html.twig');

        return $render;
    }

    /**
     * @Route("/media", name="admin.param.media")
     * Action du formulaire
     *
     * @return Response
     */
    public function media(): Response
    {
        $this->setForm('FormParamMedia', MediaType::class);
        $render = $this->generate('Media', 'MkkAdminBundle:Param:media.html.twig');

        return $render;
    }

    /**
     * @Route("/robotstxt", name="admin.param.robotstxt")
     * Action du formulaire
     *
     * @return Response
     */
    public function robotstxt(): Response
    {
        $this->setForm('FormParamRobotsTxt', RobotstxtType::class);
        $render = $this->generate('Robots.txt', 'MkkAdminBundle:Param:robotstxt.html.twig');

        return $render;
    }

    /**
     * @Route("/tinymce", name="admin.param.tinymce")
     * Action du formulaire
     *
     * @return Response
     */
    public function tinymce(): Response
    {
        $this->setForm('FormParamTinyMCE', TinymceType::class);
        $render = $this->generate('TinyMCE', 'MkkAdminBundle:Param:tinymce.html.twig');

        return $render;
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
