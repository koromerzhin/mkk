<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class DiaporamaDatabaseListener extends LibDatabaseListener
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
        $container        = $this->container;
        $diaporamaManager = $container->get('bdd.diaporama_manager');
        $diaporamaEntity  = $diaporamaManager->getTable();
        if ($this->entityInstanceofUpdate($diaporamaEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($diaporamaEntity)) {
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
        $em     = $this->em;
        $uow    = $this->uow;
        $images = $entity->getImages();
        $total  = count($images);
        $entity->setTotalnbimage($total);
        $em->persist($entity);
        $md = $em->getClassMetadata(get_class($entity));
        $uow->computeChangeSet($md, $entity);
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
        $em     = $this->em;
        $uow    = $this->uow;
        $images = $entity->getImages();
        $total  = count($images);
        $entity->setTotalnbimage($total);
        $em->persist($entity);
        $md = $em->getClassMetadata(get_class($entity));
        $uow->computeChangeSet($md, $entity);
    }
}
