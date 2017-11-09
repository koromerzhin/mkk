<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Mkk\SiteBundle\Service\DroitService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DroitCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:droit:config');
    }

    /**
     * Execution de la commande.
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->initCommand();
        $output->writeln('Gestion des droits utilisateurs');
        $this->droitService = $this->container->get(DroitService::class);
        $output->writeln('Suppression des anciennes routes');
        $this->droitService->supprimer();
        $output->writeln('Ajout des routes');
        $this->add();
        unset($input);
    }

    /**
     * Ajoute des droits.
     *
     * @return void
     */
    private function add(): void
    {
        $manager    = $this->container->get('bdd.group_manager');
        $repository = $manager->getRepository();
        $groups     = $repository->findAll();
        foreach ($groups as $group) {
            if ('superadmin' !== (string) $group->getCode()) {
                $this->droitService->add($group);
            }
        }
    }
}
