<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupTotalCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:group:total');
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
        $output->writeln("Sauvegarde du nombre d'utilisateur par groupes");
        $this->setTotalUser();
        unset($input);
    }

        /**
         * indique le nombre d'utilisateur par groupe
         *
         * @return    void
         */
    private function setTotalUser(): void
    {
        $groupManager    = $this->container->get('bdd.group_manager');
        $groupRepository = $groupManager->getRepository();
        $data            = $groupRepository->commandTotalUser();
        $batchSize       = 5;
        foreach ($data as $i => $row) {
            $idgroup = $row['id'];
            $total   = $row['total'];
            $group   = $groupRepository->find($idgroup);
            if ($group) {
                $group->setTotalnbuser($total);
                $groupManager->persist($group);
                if (($i % $batchSize) == 0) {
                    $groupManager->flush();
                }
            }
        }

        $groupManager->flush();
    }
}
