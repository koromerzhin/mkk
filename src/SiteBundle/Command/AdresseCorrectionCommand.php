<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdresseCorrectionCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:correction:adresse');
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
        $output->writeln('Vérification des adresses');
        $adresseManager    = $this->container->get('bdd.adresse_manager');
        $adresseRepository = $adresseManager->getRepository();
        $adresseEntity     = $adresseManager->getTable();
        $adresse           = new $adresseEntity();
        $tab               = [];
        $methods           = get_class_methods($adresse);
        $code              = 'getRef';
        foreach ($methods as $method) {
            if (substr($method, 0, strlen($code)) === $code) {
                $tab[$method] = strtolower(str_replace($code, 'ref', $method));
            }
        }

        $tabsupp = [];
        foreach ($tab as $method => $field) {
            $adresses = $adresseRepository->commandFind($field);
            if (0 !== count($adresses)) {
                $supp    = $this->adresseVerifDoublon($adresses, $method, $tabsupp);
                $tabsupp = array_merge($tabsupp, $supp);
            }
        }

        $output->writeln('Suppression de ' . count($tabsupp) . ' adresse(s)');
        foreach ($tabsupp as $supp) {
            $adresseManager->remove($supp);
        }

        $adresseManager->flush();
        unset($input);
    }

    /**
     * vérifie les doublones.
     *
     * @param array  $adresses adresses
     * @param string $field    champs
     *
     * @return array
     */
    private function adresseVerifDoublon($adresses, $field): array
    {
        $tab  = [];
        $supp = [];
        foreach ($adresses as $adresse) {
            $idfield = $adresse->$field()->getId();
            $info    = $adresse->getInfo();
            $cp      = $adresse->getCp();
            $ville   = $adresse->getVille();
            $data    = $info . ' ' . $cp . ' ' . $ville;
            if (!isset($tab[$field][$idfield][$data])) {
                $tab[$field][$idfield][$data] = $adresse->getId();
            } else {
                $supp[] = $adresse;
            }
        }

        return $supp;
    }
}
