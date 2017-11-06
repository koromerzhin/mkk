<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TagTotalCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:tag:total');
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
        $mkkTagManager = $this->container->get('mkk.tag_manager');
        $output->writeln('Sauvegarde du nombre de blogs par tag');
        $mkkTagManager->setTotalBlogs();
        $output->writeln('Sauvegarde du nombre de bookmarks par tag');
        $mkkTagManager->setTotalBookmarks();
        unset($input);
    }
}
