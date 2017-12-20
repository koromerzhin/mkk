<?php

namespace Mkk\SiteBundle\Lib;

use Mkk\SiteBundle\Service\BreadCrumbService;
use Mkk\SiteBundle\Service\ParamService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

class LibController extends Controller
{
    /**
     * @var BreadCrumbService
     */
    protected $breadcrumbService;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    private $paramViews;

    /**
     * @var Router
     */
    private $router;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->paramViews        = [];
        $this->container         = $container;
        $this->breadcrumbService = $container->get(BreadCrumbService::class);
        $this->formFactory       = $container->get('form.factory');
        $this->requestStack      = $container->get('request_stack');
        $this->request           = $this->requestStack->getCurrentRequest();
        $this->router            = $container->get('router');
    }

    /**
     * Affiche la vue.
     *
     * @param string   $view       template
     * @param array    $parameters data
     * @param Response $response   ??
     *
     * @return Response
     */
    public function render($view, array $parameters = [], ?Response $response = NULL): Response
    {
        $this->addParamViewsSite($parameters);
        $render = parent::render($view, $this->paramViews, $response);

        return $render;
    }

    /**
     * Ajoute des parametres à twig.
     *
     * @param array $parameters tableau de data
     *
     * @return void
     */
    protected function addParamViewsSite(array $parameters): void
    {
        $this->paramViews = array_merge($this->paramViews, $parameters);
        $this->addBreadcrumb();
        $this->addImageBackground();
        $this->addEnseigne();
        $this->addFavicon();
        $this->addManifest();
        $this->addParams();
        $this->addParamsMetatags();
    }

    /**
     * Initialise Metatags.
     *
     * @return void
     */
    private function initMetatags(): void
    {
        if (!isset($this->paramViews['meta_titre'])) {
            $this->paramViews['meta_titre'] = '';
        }

        if (!isset($this->paramViews['metatags'])) {
            $this->paramViews['metatags'] = [];
        }

        if (!isset($this->paramViews['metatags']['description'])) {
            $this->paramViews['metatags']['description'] = '';
        }

        if (!isset($this->paramViews['metatags']['keywords'])) {
            $this->paramViews['metatags']['keywords'] = '';
        }
    }

    /**
     * Génére metatags pour site Internet.
     *
     * @return void
     */
    private function addParamsMetatags(): void
    {
        $this->initMetatags();
        $this->setRouteMetatags();

        if (!isset($this->paramViews['param'])) {
            return;
        }

        $params = $this->paramViews['param'];
        $this->setMetaTitre();

        if (isset($params['meta_theme_color']) && '' !== $params['meta_theme_color']) {
            $this->paramViews['metatags']['theme-color'] = $params['meta_theme_color'];
        }

        if (isset($params['google_webmastertool']) && '' !== $params['google_webmastertool']) {
            $this->paramViews['metatags']['google-site-verification'] = $params['google_webmastertool'];
        }

        $this->setDefaultMetatags();

        if ('' !== $this->paramViews['meta_titre']) {
            $this->paramViews['metatags']['og:site_name'] = $this->paramViews['meta_titre'];
        }
    }

    /**
     * Génére les métatags par défault.
     *
     * @return void
     */
    private function setDefaultMetatags(): void
    {
        $this->setMetaDescription();
        $this->setMetaKeywords();
        $this->setMetaOgTitre();
        $this->setMetaUrl();
    }

    /**
     * Set.
     *
     * @return void
     */
    private function setMetaUrl(): void
    {
        $params = $this->paramViews['param'];
        if (isset($params['url'])) {
            $url       = $params['url'];
            $infoRoute = $this->request->attributes->all();
            $url       = $url . $this->router->generate($infoRoute['_route'], $infoRoute['_route_params']);

            $this->paramViews['metatags']['og:url'] = $url;
        }
    }

    /**
     * Set.
     *
     * @return void
     */
    private function setMetaOgTitre(): void
    {
        $params = $this->paramViews['param'];
        if (isset($params['meta_titre']) && '' !== $params['meta_titre']) {
            $this->paramViews['metatags']['og:title'] = $params['meta_titre'];
        }
    }

    /**
     * Set.
     *
     * @return void
     */
    private function setMetaKeywords(): void
    {
        $params = $this->paramViews['param'];
        if (isset($params['meta_keywords']) && '' !== $params['meta_keywords'] && $this->paramViews['metatags']['keywords'] === '') {
            $this->paramViews['metatags']['keywords'] = $params['meta_keywords'];
        }
    }

    /**
     * Set.
     *
     * @return void
     */
    private function setMetaDescription(): void
    {
        $params = $this->paramViews['param'];
        if (isset($params['meta_description']) && '' !== $params['meta_description'] && $this->paramViews['metatags']['description'] === '') {
            $this->paramViews['metatags']['description'] = $params['meta_description'];
        }
    }

    /**
     * Génére les metatags par rapport à la route.
     *
     * @return void
     */
    private function setRouteMetatags(): void
    {
        $route           = $this->request->get('_route');
        $tableManager    = $this->get('bdd.metariane_manager');
        $tableRepository = $tableManager->getRepository();
        $entity          = $tableRepository->findOneByRoute($route);
        if (!$entity) {
            return;
        }

        if ('' === $this->paramViews['meta_titre']) {
            $this->paramViews['meta_titre'] = $entity->getTitre();
        }

        if ($this->paramViews['metatags']['description'] === '') {
            $this->paramViews['metatags']['description'] = $entity->getDescription();
        }

        if ($this->paramViews['metatags']['keywords'] === '') {
            $this->paramViews['metatags']['keywords'] = $entity->getKeywords();
        }
    }

    /**
     * Génére le titre.
     *
     * @return void
     */
    private function setMetaTitre(): void
    {
        $params    = $this->paramViews['param'];
        $metaTitre = $this->paramViews['meta_titre'];
        if (!isset($params['meta_titre']) || '' === $params['meta_titre']) {
            return;
        }

        if (!isset($params['seo_titre']) || 0 === (int) $params['seo_titre']) {
            if ('' !== $metaTitre) {
                $metaTitre = "{$metaTitre} -";
            }

            $metaTitre = "{$metaTitre} {$params['meta_titre']} ";
        } else {
            if ('' !== $metaTitre) {
                $metaTitre = "{$params['meta_titre']} - {$metaTitre}";
            } else {
                $metaTitre = "{$params['meta_titre']}";
            }
        }

        $this->paramViews['meta_titre'] = $metaTitre;
    }

    /**
     * Ajoute les paramètres au site Internet.
     *
     * @return void
     */
    private function addParams(): void
    {
        $params                    = $this->get(ParamService::class)->listing();
        $this->paramViews['param'] = $params;
    }

    /**
     * Ajoute le favicon a twig.
     *
     * @return void
     */
    private function addFavicon(): void
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if (is_file('favicon.png')) {
            $favicon = [
            'mime' => finfo_file($finfo, 'favicon.png'),
            'url'  => 'favicon.png',
            ];
        } elseif (is_file('favicon.ico')) {
            $favicon = [
            'mime' => finfo_file($finfo, 'favicon.ico'),
            'url'  => 'favicon.ico',
            ];
        }

        if (isset($favicon)) {
            $this->paramViews['favicon'] = $favicon;
        }
    }

    /**
     * Récupére le manifest générer par webpack.
     *
     * @return void
     */
    private function addManifest(): void
    {
        $file     = 'assets/manifest.json';
        $manifest = [];
        if (is_file($file)) {
            $manifest = json_decode(file_get_contents($file), TRUE);
        }

        $this->paramViews['manifest'] = $manifest;
    }

    /**
     * Ajoute le breadcrumb au twig.
     *
     * @return void
     */
    private function addBreadcrumb(): void
    {
        $breadcrumb                     = $this->container->get(BreadCrumbService::class)->get();
        $this->paramViews['breadcrumb'] = $breadcrumb;
    }

    /**
     * Ajoute l'enseigne au twig.
     *
     * @return void
     */
    private function addEnseigne(): void
    {
        $etablissementManager = $this->get('bdd.etablissement_manager');
        $etablissementRepo    = $etablissementManager->getRepository();
        $enseigne             = $etablissementRepo->findoneBy(['type' => 'enseigne']);
        if ($enseigne) {
            $this->paramViews['enseigne'] = $enseigne;
        }
    }

    /**
     * Ajouter les images en background.
     *
     * @return void
     */
    private function addImageBackground(): void
    {
        $this->paramViews['imgaccueil'] = '';
        $dossier                        = 'fichiers/login';
        if (!is_dir($dossier)) {
            return;
        }

        $tabfichiers = glob("{$dossier}/*.*");
        if (FALSE !== (bool) $tabfichiers && is_array($tabfichiers)) {
            $id                             = array_rand($tabfichiers, 1);
            $imgaccueil                     = $this->generateUrl('site.index') . $tabfichiers[$id];
            $this->paramViews['imgaccueil'] = $imgaccueil;
        }
    }
}
