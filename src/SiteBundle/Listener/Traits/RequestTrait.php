<?php

namespace Mkk\SiteBundle\Listener\Traits;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

trait RequestTrait
{
    /**
     * Retour pour acl.
     *
     * @param int              $error code d'erreur
     * @param getResponseEvent $event evenement
     *
     * @return void
     */
    private function aclReturn(int $error, getResponseEvent $event): void
    {
        $viderVerif = $this->verifUrlVider($event);
        if ($this->isError401($error) && $event->getRequest()->isXmlHttpRequest()) {
            throw new HttpException(401, 'Une authentification est nécessaire pour accéder à la ressource');
        }

        if ($this->isError401($error)) {
            throw new AccessDeniedException('no acces');
        }

        if ($this->isError403($error) || $viderVerif) {
            $text = "Le serveur a compris la requête, mais refuse de l'exécuter.";
            $text = "{$text} Contrairement à l'erreur 401, s'authentifier ne fera aucune différence.";
            $text = "{$text} Sur les serveurs où l'authentification est requise,";
            $text = "{$text} cela signifie généralement que l'authentification a été acceptée mais";
            $text = "{$text} que les droits d'accès ne permettent pas au client d'accéder à la ressource";
            throw new HttpException(403, $text);
        }
    }

    /**
     * URL pour la desactivation du site.
     *
     * @param string $route   route
     * @param int    $disable bool
     *
     * @return string
     */
    private function setUrlDisableRequest(string $route, bool $disable): string
    {
        $url = '';
        if ('scripts.disable' !== $route && true === $disable) {
            $url = $this->router->generate('scripts.disable');
        } elseif ('scripts.disable' === $route && false === $disable) {
            $url = $this->router->generate('site.index');
        }

        return (string) $url;
    }

    /**
     * Verifie les Droits utilisateurs suivant la page.
     *
     * @param getResponseEvent $event evenement
     *
     * @return int
     */
    private function verifDroit(getResponseEvent $event): int
    {
        $container            = $this->container;
        $tokenStorage         = $container->get('security.token_storage')->getToken();
        $authorizationChecker = $container->get('security.authorization_checker');
        $groupManager         = $container->get('bdd.group_manager');
        $groupRepository      = $groupManager->getRepository();
        $superadminEntity     = $groupRepository->findOneByCode('superadmin');
        $superadmin           = $superadminEntity;
        $visiteurEntity       = $groupRepository->findOneByCode('visiteur');
        $visiteur             = $visiteurEntity;
        $group                = $visiteur;
        $isauthorized         = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (null !== $tokenStorage && $isauthorized) {
            $user  = $tokenStorage->getUser();
            $group = $user->getRefGroup();
        }

        if ($group->getCode() === $superadmin->getCode()) {
            return (int) 200;
        }

        $route         = $event->getRequest()->attributes->get('_route');
        $actionManager = $container->get('bdd.action_manager');
        $repository    = $actionManager->getRepository();
        $search        = [
            'route'    => $route,
            'refgroup' => $group,
            'etat'     => 1,
        ];

        $action = $repository->findoneBy($search);
        if (!$action) {
            if (null !== $tokenStorage && $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $error = (int) 403;
            } else {
                $error = (int) 401;
            }

            return $error;
        }

        return (int) 200;
    }

    /**
     * Pour ne pas checker des liens inutiles.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return bool
     */
    private function verifUrlNonDroit(getResponseEvent $event): bool
    {
        $route  = $event->getRequest()->attributes->get('_route');
        $retour = false;
        $url    = (0 !== substr_count($route, 'fos_') || 0 !== substr_count($route, 'scripts.'));
        $url    = ($url || 0 !== substr_count($route, 'scripts.'));
        $url    = ($url || 0 !== substr_count($route, '_profiler'));
        $url    = ($url || 0 !== substr_count($route, '_twig_'));
        $url    = ($url || 0 !== substr_count($route, '_wdt'));
        if ($url) {
            $retour = true;
        }

        return $retour;
    }

    /**
     * Liens json à ne pas vérifier.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return bool
     */
    private function verifUrlJson(getResponseEvent $event): bool
    {
        $route  = $event->getRequest()->attributes->get('_route');
        $retour = false;
        if (1 === substr_count($route, '.json.')) {
            $retour = true;
        }

        return $retour;
    }

    /**
     * Les url vider sont accessible uniquement aux super-admin.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return bool
     */
    private function verifUrlVider(getResponseEvent $event): bool
    {
        $container            = $this->container;
        $route                = $event->getRequest()->attributes->get('_route');
        $retour               = false;
        $tokenStorage         = $container->get('security.token_storage')->getToken();
        $authorizationChecker = $container->get('security.authorization_checker');
        $isAuthenticated      = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (substr_count($route, '.vider') && null !== $tokenStorage && $isAuthenticated) {
            $groupManager    = $container->get('bdd.group_manager');
            $groupRepository = $groupManager->getRepository();
            $superadmin      = $groupRepository->findOneByCode('superadmin');
            $user            = $tokenStorage->getUser();
            $group           = $user->getRefGroup()->getId();
            if ($group !== $superadmin->getId()) {
                $retour = true;
            }
        }

        return $retour;
    }

    /**
     * Verification des liens search.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return bool
     */
    private function verifUrlSearch(getResponseEvent $event): bool
    {
        $container            = $this->container;
        $route                = $event->getRequest()->attributes->get('_route');
        $groupManager         = $container->get('bdd.group_manager');
        $groupRepository      = $groupManager->getRepository();
        $visiteur             = $groupRepository->findOneByCode('visiteur');
        $retour               = false;
        $urlsearch            = substr_count($route, '.search.');
        $tokenStorage         = $container->get('security.token_storage')->getToken();
        $authorizationChecker = $container->get('security.authorization_checker');
        $isAuthenticated      = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (1 === $urlsearch && null !== $tokenStorage && $isAuthenticated) {
            $user  = $tokenStorage->getUser();
            $group = $user->getRefGroup()->getId();
            if ($group !== $visiteur->getId()) {
                $retour = true;
            }
        }

        return $retour;
    }

    /**
     * Verification des liens upload.
     *
     * @param getResponseEvent $event getResponseEvent
     *
     * @return bool
     */
    private function verifUrlUpload(getResponseEvent $event): bool
    {
        $container            = $this->container;
        $route                = $event->getRequest()->attributes->get('_route');
        $groupManager         = $container->get('bdd.group_manager');
        $groupRepository      = $groupManager->getRepository();
        $visiteur             = $groupRepository->findOneByCode('visiteur');
        $retour               = false;
        $urlupload            = substr_count($route, '.upload.');
        $tokenStorage         = $container->get('security.token_storage')->getToken();
        $authorizationChecker = $container->get('security.authorization_checker');
        $isAuthenticated      = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (1 === $urlupload && null !== $tokenStorage && $isAuthenticated) {
            $user = $tokenStorage->getUser();
            if ($user->getRefGroup()->getId() !== $visiteur->getId()) {
                $retour = true;
            }
        }

        return $retour;
    }
}
