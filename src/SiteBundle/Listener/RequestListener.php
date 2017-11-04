<?php

namespace Mkk\SiteBundle\Listener;

use Mkk\SiteBundle\Listener\Traits\RequestTrait;
use Mkk\SiteBundle\Service\ParamService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Router;
use Twig_Environment;

class RequestListener
{
    use RequestTrait;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var ParamService
     */
    private $params;

    /**
     * @var Router
     */
    private $router;

    /**
     * Initialisation RequestListener.
     *
     * @param ContainerInterface $container ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig      = $container->get('twig');
        $this->params    = $container->get(ParamService::class);
        $this->router    = $container->get('router');
    }

    /**
     * Verifie les droits utilisateurs.
     *
     *
     * @param GetResponseEvent $event getResponseEvent
     *
     * @return void
     */
    public function aclRequest(getResponseEvent $event): void
    {
        $route          = $event->getRequest()->attributes->get('_route');
        $jsonVerif      = $this->verifUrlJson($event);
        $searchVerif    = $this->verifUrlSearch($event);
        $uploadVerif    = $this->verifUrlUpload($event);
        $searchNonDroit = $this->verifUrlNonDroit($event);
        $recherche1     = ('' === $route || $jsonVerif);
        $recherche2     = ($recherche1 || $searchVerif);
        $recherche3     = ($recherche2 || $uploadVerif);
        $recherche      = ($recherche3 || $searchNonDroit);
        if ($recherche) {
            return;
        }

        $error = $this->verifDroit($event);
        $this->aclReturn($error, $event);
    }

    /**
     * Redirection quand on est connecté.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return void
     */
    public function redirectLoginRequest(GetResponseEvent $event): void
    {
        $route                = $event->getRequest()->attributes->get('_route');
        $tokenStorage         = $this->container->get('security.token_storage')->getToken();
        $authorizationChecker = $this->container->get('security.authorization_checker');
        $isAuthenticated      = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (NULL !== $tokenStorage && $isAuthenticated && 'scripts.login' === $route) {
            $url = $this->router->generate('site.index');
            $event->setResponse(new RedirectResponse($url));
        }
    }

    /**
     * Desactive l'espace publique si le site est désactivé.
     *
     * @param GetResponseEvent $event GetResponseEvent
     *
     * @return void
     */
    public function disableRequest(GetResponseEvent $event): void
    {
        $route    = (string) $event->getRequest()->attributes->get('_route');
        $param    = $this->params->listing();
        $disable  = (bool) isset($param['desactivation_etat']) ? $param['desactivation_etat'] : 0;
        $tabroute = [
            'scripts.login',
            '',
            '_wdt',
            'admin.index',
        ];

        $tokenStorage         = $this->container->get('security.token_storage')->getToken();
        $authorizationChecker = $this->container->get('security.authorization_checker');
        $isauthorized         = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (in_array($route, $tabroute, TRUE) || (NULL !== $tokenStorage && $isauthorized)) {
            return;
        }

        $url = (string) $this->setUrlDisableRequest($route, $disable);

        if ('' !== $url) {
            $redirect = new RedirectResponse($url);
            $event->setResponse($redirect);
        }
    }
}
