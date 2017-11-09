<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Descriptor\ApplicationDescription;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends ContainerAwareCommandLib
{
    const TOTALCOMMAND = 2;

    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:update');
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
        $output->writeln('Update');
        $tab = [
            'mkk:site:init',
            'mkk:group:total',
            'mkk:seo:init',
            'mkk:entity:init',
            'mkk:correction:lien',
            'mkk:correction:telephone',
            'mkk:correction:adresse',
        ];

        $application = new ApplicationDescription($this->application);
        $namespaces  = $application->getNamespaces();
        foreach ($namespaces as $namespace) {
            foreach ($namespace['commands'] as $command) {
                $tabcommand = explode(':', $command);
                $test1      = self::TOTALCOMMAND === count($tabcommand);
                $test2      = 'update' === $tabcommand[1];
                $test3      = !in_array($command, [$this->getName(), 'translation:update']);
                if ($test1 && $test2 && $test3) {
                    $tab[] = $command;
                }
            }
        }

        foreach ($tab as $code) {
            $this->executeCommand($code, $input, $output);
        }

        $output->writeln('Fin Update MKK');
    }
}
