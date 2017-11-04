<?php

namespace Mkk\SiteBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Kernel;

class DoctrineExtensionListener implements ContainerAwareInterface
{
    const MAJOR_VERSION = 2;
    const MINOR_VERSION = 6;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Description of what this does.
     *
     * @param ContainerInterface $container DI
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = NULL): void
    {
        $this->container = $container;
    }

    /**
     * Description of what this does.
     *
     * @param GetResponseEvent $event event
     *
     * @return void
     */
    public function onLateKernelRequest(GetResponseEvent $event): void
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    /**
     * Description of what this does.
     *
     * @return void
     */
    public function onConsoleCommand(): void
    {
        $this->container->get('gedmo.listener.translatable')->setTranslatableLocale($this->container->get('translator')->getLocale());
    }

    /**
     * Description of what this does.
     *
     * @param GetResponseEvent $event event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (Kernel::MAJOR_VERSION === self::MAJOR_VERSION && Kernel::MINOR_VERSION < self::MINOR_VERSION) {
            $securityContext = $this->container->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE);
            $isAuthRemember  = $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED');
            if (NULL !== $securityContext && NULL !== $securityContext->getToken() && $isAuthRemember) {
                $loggable = $this->container->get('gedmo.listener.loggable');
                $loggable->setUsername($securityContext->getToken()->getUsername());
            }
        } else {
            $tokenStorage         = $this->container->get('security.token_storage')->getToken();
            $authorizationChecker = $this->container->get('security.authorization_checker');
            if (NULL !== $tokenStorage && $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $loggable = $this->container->get('gedmo.listener.loggable');
                $loggable->setUsername($tokenStorage->getUser());
                $blameable = $this->container->get('gedmo.listener.blameable');
                $blameable->setUserValue($tokenStorage->getUser());
            }
        }

        unset($event);
    }
}
