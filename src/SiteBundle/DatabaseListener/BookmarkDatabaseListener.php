<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class BookmarkDatabaseListener extends LibDatabaseListener
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
        $container       = $this->container;
        $bookmarkManager = $container->get('bdd.bookmark_manager');
        $bookmarkEntity  = $bookmarkManager->getTable();
        if ($this->entityInstanceofUpdate($bookmarkEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($bookmarkEntity)) {
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
        $em   = $this->em;
        $uow  = $this->uow;
        $tags = $entity->getTags();
        foreach ($tags as $tag) {
            $total = count($tag->getBookmarks()) - 1;
            $tag->setTotalnbbookmark($total);
            $em->persist($tag);
            $md = $em->getClassMetadata(get_class($tag));
            $uow->computeChangeSet($md, $tag);
        }
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
        $em   = $this->em;
        $uow  = $this->uow;
        $tags = $entity->getTags();
        foreach ($tags as $tag) {
            $total = count($tag->getBookmarks());
            $tag->setTotalnbbookmark($total);
            $em->persist($tag);
            $md = $em->getClassMetadata(get_class($tag));
            $uow->computeChangeSet($md, $tag);
        }
    }
}
