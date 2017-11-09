<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeoCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:seo:init');
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
        $routes = $this->router->getRouteCollection()->all();
        $data   = [];
        foreach ($routes as $name => $route) {
            $pattern = $route->getPath();
            $test1   = 0 === (int) substr_count($name, '_');
            $test2   = 0 === (int) substr_count($name, 'admin.');
            $test3   = 0 === (int) substr_count($name, 'scripts.');
            if ($test1 && $test2 && $test3) {
                $data[$name] = $pattern;
            }
        }

        $this->tableManager    = $this->container->get('bdd.metariane_manager');
        $this->tableRepository = $this->tableManager->getRepository();
        $this->supprimerSeo($data);
        $this->ajouterSeo($data);

        unset($input, $output);
    }

    /**
     * Supprimer route inutile en base de données.
     *
     * @param array $data liste des routes valables
     *
     * @return void
     */
    private function supprimerSeo(array $data = []): void
    {
        $tab = [];
        foreach (array_keys($data) as $name) {
            $tab[] = $name;
        }

        $tab       = $this->tableRepository->supprimer($tab);
        $batchSize = 5;
        foreach ($tab as $i => $row) {
            $this->tableManager->remove($row);
            ++$i;
            if (0 === ($i % $batchSize)) {
                $this->tableManager->flush();
            }
        }

        $this->tableManager->flush();
    }

    /**
     * Ajoute route en base de données.
     *
     * @param array $data liste des routes valables
     *
     * @return void
     */
    private function ajouterSeo(array $data = []): void
    {
        $table     = $this->tableManager->getTable();
        $batchSize = 5;
        $i         = 0;
        foreach ($data as $route => $pattern) {
            $entity = $this->tableRepository->findOneByRoute($route);
            if (!$entity) {
                $entity = new $table();
                $entity->setRoute($route);
            }

            $entity->setPattern($pattern);
            $this->tableManager->persist($entity);
            ++$i;
            if (0 === ($i % $batchSize)) {
                $this->tableManager->flush();
            }
        }

        $this->tableManager->flush();
    }
}
