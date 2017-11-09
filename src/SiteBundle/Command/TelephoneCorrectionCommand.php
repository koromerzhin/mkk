<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TelephoneCorrectionCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:correction:telephone');
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
        $output->writeln('Vérification des telephones');
        $telephoneManager    = $this->container->get('bdd.telephone_manager');
        $telephoneRepository = $telephoneManager->getRepository();
        $telephoneEntity     = $telephoneManager->getTable();
        $telephone           = new $telephoneEntity();
        $tab                 = [];
        $methods             = get_class_methods($telephone);
        $code                = 'getRef';
        foreach ($methods as $method) {
            if (substr($method, 0, strlen($code)) === $code) {
                $tab[$method] = strtolower(str_replace($code, 'ref', $method));
            }
        }

        $tabsupp = [];
        foreach ($tab as $method => $field) {
            $telephones = $telephoneRepository->commandFind($field);
            if (0 !== count($telephones)) {
                $supp    = $this->telephoneVerifDoublon($telephones, $method, $tabsupp);
                $tabsupp = array_merge($tabsupp, $supp);
            }
        }

        $output->writeln('Suppression de ' . count($tabsupp) . ' telephone(s)');
        foreach ($tabsupp as $supp) {
            $telephoneManager->remove($supp);
        }

        $telephoneManager->flush();
        unset($input);
    }

    /**
     * Verifie les doublons.
     *
     * @param array  $telephones tableau de téléphone
     * @param string $field      champs
     *
     * @return array
     */
    private function telephoneVerifDoublon($telephones, $field): array
    {
        $tab  = [];
        $supp = [];
        foreach ($telephones as $telephone) {
            $idfield = $telephone->$field()->getId();
            $data    = $telephone->getChiffre();
            if (!isset($tab[$field][$idfield][$data])) {
                $tab[$field][$idfield][$data] = $telephone->getId();
            } else {
                $supp[] = $telephone;
            }
        }

        return $supp;
    }
}
