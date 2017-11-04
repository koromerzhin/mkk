<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class EmplacementDatabaseListener extends LibDatabaseListener
{
    /**
     * Fonction executé dans le listener
     * permet de faire les modifications sur les tables.
     *
     * @param OnFlushEventArgs $args arguments
     *
     * @return void
     */
    public function launch(OnFlushEventArgs $args): void
    {
        $this->setVarargs($args);
        $container          = $this->container;
        $emplacementManager = $container->get('bdd.emplacement_manager');
        $emplacementEntity  = $emplacementManager->getTable();
        if ($this->entityInstanceofUpdate($emplacementEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($emplacementEntity)) {
            $this->onDeleteTable($this->entity);
        }
    }

    /**
     * Delete sur table.
     *
     * @param mixed $entity entité
     *
     * @return void
     */
    private function onDeleteTable($entity): void
    {
        $em           = $this->em;
        $uow          = $this->uow;
        $evenement    = $entity->getRefEvenement();
        $emplacements = $evenement->getEmplacements();
        $mindate      = 0;
        $maxdate      = 0;
        $place        = 0;
        $illimite     = 0;
        foreach ($emplacements as $emplacement) {
            if ($emplacement->getId() !== $entity->getId()) {
                $etatPlaceillimite = $emplacement->getPlaceillimite();
                if (0 === $etatPlaceillimite) {
                    $illimite = 0;
                } else {
                    $illimite = 1;
                }

                $totalplace = $emplacement->getTotalnbplace();
                $tempsmin   = $emplacement->getMindate();
                if (0 === $mindate || $mindate > $tempsmin) {
                    $mindate = $tempsmin;
                }

                $tempsmax = $emplacement->getMaxdate();
                if (0 === $maxdate || $maxdate < $tempsmax) {
                    $maxdate = $tempsmax;
                }

                $place = $place + $totalplace;
            }
        }

        $type = $evenement->getType();
        if (1 === $type) {
            $illimite = $evenement->getPlaceillimite();
            $place    = $evenement->getTotalnbplace();
        }

        $total = count($emplacements);
        $evenement->setPlaceillimite($illimite);
        $evenement->setTotalnbplace($place);
        $evenement->setMindate($mindate);
        $evenement->setMaxdate($maxdate);
        $evenement->setTotalnbemplacement($total);
        $em->persist($evenement);
        $md = $em->getClassMetadata(get_class($evenement));
        $uow->computeChangeSet($md, $evenement);
    }

    /**
     * Flush sur table.
     *
     * @param mixed $entity entité
     *
     * @return void
     */
    private function onFlushTable($entity): void
    {
        $em           = $this->em;
        $uow          = $this->uow;
        $evenement    = $entity->getRefEvenement();
        $emplacements = $evenement->getEmplacements();
        $mindate      = 0;
        $maxdate      = 0;
        $place        = 0;
        $illimite     = 0;
        foreach ($emplacements as $emplacement) {
            $etatPlaceillimite = $emplacement->getPlaceillimite();
            if (0 === $etatPlaceillimite) {
                $illimite = 0;
            } else {
                $illimite = 1;
            }

            $totalplace = $emplacement->getTotalnbplace();
            $tempsmin   = $emplacement->getMindate();
            if (0 === $mindate || $mindate > $tempsmin) {
                $mindate = $tempsmin;
            }

            $tempsmax = $emplacement->getMaxdate();
            if (0 === $maxdate || $maxdate < $tempsmax) {
                $maxdate = $tempsmax;
            }

            $place = $place + $totalplace;
        }

        $type = $evenement->getType();
        if (1 === $type) {
            $illimite = $evenement->getPlaceillimite();
            $place    = $evenement->getTotalnbplace();
        }

        $total = count($emplacements);
        $evenement->setPlaceillimite($illimite);
        $evenement->setTotalnbplace($place);
        $evenement->setMindate($mindate);
        $evenement->setMaxdate($maxdate);
        $evenement->setTotalnbemplacement($total);
        $em->persist($evenement);
        $md = $em->getClassMetadata(get_class($evenement));
        $uow->computeChangeSet($md, $evenement);
    }
}
