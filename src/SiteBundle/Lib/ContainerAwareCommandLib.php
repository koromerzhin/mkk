<?php

namespace Mkk\SiteBundle\Lib;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Router;

abstract class ContainerAwareCommandLib extends ContainerAwareCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $application;

    protected $kernel;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Commande à éxécuter.
     *
     * @param string          $code   commande à executer
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     *
     * @return void
     */
    public function executeCommand($code, InputInterface $input, OutputInterface $output): void
    {
        $application = $this->getApplication();
        $command     = $application->find($code);
        $command->run($input, $output);
    }

    /**
     * Initialize command.
     *
     * @return void
     *
     * @author
     * @copyright
     */
    public function initCommand(): void
    {
        $this->container   = $this->getContainer();
        $this->application = $this->getApplication();
        $this->kernel      = $this->application->getKernel();
        $this->container   = $this->kernel->getContainer();
        $this->router      = $this->container->get('router');
    }
}
