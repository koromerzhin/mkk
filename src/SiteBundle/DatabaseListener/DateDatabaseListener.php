<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class DateDatabaseListener extends LibDatabaseListener
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
        $container   = $this->container;
        $dateManager = $container->get('bdd.date_manager');
        $dateEntity  = $dateManager->getTable();
        if ($this->entityInstanceofUpdate($dateEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($dateEntity)) {
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
        $em          = $this->em;
        $uow         = $this->uow;
        $emplacement = $entity->getRefEmplacement();
        $dates       = $emplacement->getDates();
        $mindate     = 0;
        $maxdate     = 0;
        $total       = count($dates);
        $place       = 0;
        $illimite    = 0;
        foreach ($dates as $date) {
            if ($date->getId() !== $entity->getId()) {
                $etatPlaceillimite = $date->getPlaceillimite();
                if (0 === $etatPlaceillimite) {
                    $illimite = 0;
                } else {
                    $illimite = 1;
                }

                $totalplace = $date->getPlace();
                $temps      = $date->getDebut();
                if (0 === $mindate || $mindate > $temps) {
                    $mindate = $temps;
                }

                if (0 === $maxdate || $maxdate < $temps) {
                    $maxdate = $temps;
                }

                $place = $place + $totalplace;
            }
        }

        $emplacement->setPlaceillimite($illimite);
        $emplacement->setTotalnbplace($place);
        $emplacement->setMindate($mindate);
        $emplacement->setMaxdate($maxdate);
        $emplacement->setTotalnbdate($total);
        $em->persist($emplacement);
        $md = $em->getClassMetadata(get_class($emplacement));
        $uow->computeChangeSet($md, $emplacement);
        $this->onFlushEmplacement($emplacement);
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
        $em          = $this->em;
        $uow         = $this->uow;
        $emplacement = $entity->getRefEmplacement();
        $dates       = $emplacement->getDates();
        $mindate     = 0;
        $maxdate     = 0;
        $total       = count($dates);
        $place       = 0;
        $illimite    = 0;
        foreach ($dates as $date) {
            $etatPlaceillimite = $date->getPlaceillimite();
            if (0 === $etatPlaceillimite) {
                $illimite = 0;
            } else {
                $illimite = 1;
            }

            $totalplace = $date->getPlace();
            $temps      = $date->getDebut();
            if (0 === $mindate || $mindate > $temps) {
                $mindate = $temps;
            }

            if (0 === $maxdate || $maxdate < $temps) {
                $maxdate = $temps;
            }

            $place = $place + $totalplace;
        }

        $emplacement->setPlaceillimite($illimite);
        $emplacement->setTotalnbplace($place);
        $emplacement->setMindate($mindate);
        $emplacement->setMaxdate($maxdate);
        $emplacement->setTotalnbdate($total);
        $em->persist($emplacement);
        $md = $em->getClassMetadata(get_class($emplacement));
        $uow->computeChangeSet($md, $emplacement);
        $this->onFlushEmplacement($emplacement);
    }
}
