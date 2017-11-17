<?php

namespace Mkk\SiteBundle\Lib;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LibModal
{
    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Init.
     *
     * @param ContainerInterface $container DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container  = $container;
        $this->templating = $container->get('templating');
    }
}
