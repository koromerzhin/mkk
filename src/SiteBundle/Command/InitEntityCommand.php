<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Command\Init\NafTrait;
use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Descriptor\ApplicationDescription;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitEntityCommand extends ContainerAwareCommandLib
{
    use NafTrait;

    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:entity:init');
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
        $output->writeln('Initialisation des entités');
        $this->setInitNaf($output);
        $this->setGroup();
        $this->setEnseigne();
        $this->setCategorieBlog();
        $this->correctionMenu();
        $this->correctionEtablissement();
        $this->correctionCategorie();
        $application = new ApplicationDescription($this->application);
        $namespaces  = $application->getNamespaces();
        $tab         = [];
        foreach ($namespaces as $namespace) {
            foreach ($namespace['commands'] as $command) {
                if (0 !== substr_count($command, 'entity:init') && $command !== $this->getName()) {
                    $tab[] = $command;
                }
            }
        }

        foreach ($tab as $code) {
            $this->executeCommand($code, $input, $output);
        }
    }

    /**
     * Corrige le menu.
     *
     * @return void
     */
    private function correctionMenu(): void
    {
        $menuManager    = $this->container->get('bdd.menu_manager');
        $menuRepository = $menuManager->getRepository();
        $menus          = $menuRepository->findAll();
        foreach ($menus as $menu) {
            $parent = $menu->getParent();
            if (NULL !== $parent) {
                $menu->setRefMenu($parent);
                $menu->setParent(NULL);
                $menuManager->persistAndFlush($menu);
            }
        }

        $menus = $menuRepository->findBySeparateur(1);
        foreach ($menus as $menu) {
            $menuManager->removeAndFlush($menu);
        }
    }

    /**
     * Corrige les parent.
     *
     * @return void
     */
    private function correctionEtablissement(): void
    {
        $etablissementManager = $this->container->get('bdd.etablissement_manager');
        $etablissementRepo    = $etablissementManager->getRepository();
        $etablissements       = $etablissementRepo->findBy(['refetablissement' => NULL]);
        foreach ($etablissements as $etablissement) {
            $parent = $etablissement->getParent();
            if (NULL !== $parent) {
                $etablissement->setRefEtablissement($parent);
                $etablissementManager->persistAndFlush($etablissement);
            }
        }
    }

    /**
     * Corrige les parent.
     *
     * @return void
     */
    private function correctionCategorie(): void
    {
        $categorieManager    = $this->container->get('bdd.categorie_manager');
        $categorieRepository = $categorieManager->getRepository();
        $categories          = $categorieRepository->findBy(['refcategorie' => NULL]);
        foreach ($categories as $categorie) {
            $parent = $categorie->getParent();
            if (NULL !== $parent) {
                $categorie->setRefCategorie($parent);
                $categorieManager->persistAndFlush($categorie);
            }
        }
    }

    /**
     * Corrige le total Blog pour les categories.
     *
     * @return void
     */
    private function setCategorieBlog(): void
    {
        $categorieManager    = $this->container->get('bdd.categorie_manager');
        $categorieRepository = $categorieManager->getRepository();
        $categories          = $categorieRepository->findBy(['totalnbblog' => 0]);
        foreach ($categories as $categorie) {
            $totalnbblog = count($categorie->getBlogs());
            $categorie->setTotalnbblog($totalnbblog);
            $categorieManager->persist($categorie);
        }

        $categorieManager->flush();
    }

    /**
     * Génére l'enseigne.
     *
     * @return void
     */
    private function setEnseigne(): void
    {
        $etablissementManager = $this->container->get('bdd.etablissement_manager');
        $etablissementEntity  = $etablissementManager->getTable();
        $etablissementRepo    = $etablissementManager->getRepository();
        $enseigne             = $etablissementRepo->findOneByType('enseigne');
        if (!$enseigne) {
            $enseigne = new $etablissementEntity();
            $enseigne->setType('enseigne');
            $etablissementManager->persistAndFlush($enseigne);
        }
    }

    /**
     * Génére les groupes par défault.
     *
     * @return void
     */
    private function setGroup(): void
    {
        $groupManager    = $this->container->get('bdd.group_manager');
        $groupRepository = $groupManager->getRepository();
        $groupEntity     = $groupManager->getTable();
        $visiteur        = $groupRepository->findOneByCode('visiteur');
        if (!$visiteur) {
            $group = new $groupEntity();
            $group->setCode('visiteur');
            $group->setNom('visiteur');
            $groupManager->persistAndFlush($group);
        }

        $superadmin = $groupRepository->findOneByCode('superadmin');
        if (!$superadmin) {
            $group = new $groupEntity();
            $group->setCode('superadmin');
            $group->setNom('superadmin');
            $groupManager->persistAndFlush($group);
        }
    }
}
