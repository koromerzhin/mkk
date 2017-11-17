<?php

namespace Mkk\SiteBundle\Lib;

use Doctrine\ORM\EntityManager;
use Mkk\SiteBundle\Service\ParamService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\ResourceBundle\LanguageBundleInterface;

abstract class LibAbstractType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var KernelInterface
     */
    protected $kernel;
    /**
     * @var LanguageBundleInterface
     */
    protected $languageBundle;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Init Formulaire.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container      = $container;
        $this->em             = $container->get('doctrine.orm.entity_manager');
        $this->kernel         = $container->get('kernel');
        $this->params         = $container->get(ParamService::class)->listing();
        $requestStack         = $container->get('request_stack');
        $request              = $requestStack->getCurrentRequest();
        $this->request        = $request;
        $locale               = $request->getLocale();
        $this->locale         = $locale;
        $languageBundle       = Intl::getLanguageBundle();
        $this->languageBundle = $languageBundle;
        $this->setEntityFolder();
    }

    /**
     * Récupére le namespace.
     *
     * @return string
     *
     * @author
     * @copyright
     */
    public function getNamespace(): string
    {
        return (string) $this->namespace;
    }

    /**
     * Récupére le namespace du site.
     *
     * @return void
     */
    private function setEntityFolder(): void
    {
        foreach ($this->kernel->registerBundles() as $row) {
            $name = $row->getName();
            if (0 !== substr_count($name, 'SiteBundle') && 0 === substr_count($name, 'MkkSiteBundle')) {
                $namespace = str_replace('SiteBundle', '', $name);
                $this->setNamespace($namespace);
            }
        }
    }

    /**
     * Set namespace.
     *
     * @param string $namespace namespace
     *
     * @return void
     */
    private function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }
}
