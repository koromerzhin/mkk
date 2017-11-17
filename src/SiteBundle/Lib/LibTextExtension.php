<?php

namespace Mkk\SiteBundle\Lib;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\ResourceBundle\LanguageBundleInterface;
use Twig_Extension;

class LibTextExtension extends Twig_Extension
{
    /**
     * @var LanguageBundleInterface
     */
    protected $languageBundle;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container      = $container;
        $languageBundle       = Intl::getLanguageBundle();
        $this->languageBundle = $languageBundle;
        $this->requestStack   = $container->get('request_stack');
        $this->request        = $this->requestStack->getCurrentRequest();
    }
}
