<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LienCorrectionCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:correction:lien');
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
        $output->writeln('Vérification des liens');
        $lienManager    = $this->container->get('bdd.lien_manager');
        $lienRepository = $lienManager->getRepository();
        $lienEntity     = $lienManager->getTable();
        $lien           = new $lienEntity();
        $tab            = [];
        $methods        = get_class_methods($lien);
        $code           = 'getRef';
        foreach ($methods as $method) {
            if (substr($method, 0, strlen($code)) == $code) {
                $tab[$method] = strtolower(str_replace($code, 'ref', $method));
            }
        }

        $tabsupp = [];
        foreach ($tab as $method => $field) {
            $liens = $lienRepository->commandFind($field);
            if (count($liens) != 0) {
                $supp    = $this->lienVerifDoublon($liens, $method, $tabsupp);
                $tabsupp = array_merge($tabsupp, $supp);
            }
        }

        $output->writeln('Suppression de ' . count($tabsupp) . ' lien(s)');
        foreach ($tabsupp as $supp) {
            $lienManager->remove($supp);
        }

        $lienManager->flush();
        unset($input);
    }

    /**
     * Verifie les doublons
     *
     * @param     array $liens tableau de liens
     * @param     field $field champs
     * @return    array
     */
    private function lienVerifDoublon($liens, $field)
    {
        $tab  = [];
        $supp = [];
        foreach ($liens as $lien) {
            $idfield = $lien->$field()->getId();
            $data    = $lien->getAdresse();
            if (! isset($tab[$field][$idfield][$data])) {
                $tab[$field][$idfield][$data] = $lien->getId();
            } else {
                $supp[] = $lien;
            }
        }

        return $supp;
    }
}
