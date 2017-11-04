<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class BlogDatabaseListener extends LibDatabaseListener
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
        $blogManager = $container->get('bdd.blog_manager');
        $blogEntity  = $blogManager->getTable();
        if ($this->entityInstanceofUpdate($blogEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($blogEntity)) {
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
            $total = count($tag->getBlogs()) - 1;
            $tag->setTotalnbblog($total);
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
            $total = count($tag->getBlogs());
            $tag->setTotalnbblog($total);
            $em->persist($tag);
            $md = $em->getClassMetadata(get_class($tag));
            $uow->computeChangeSet($md, $tag);
        }

        $categorie   = $entity->getRefCategorie();
        $totalnbblog = count($categorie->getBlogs());
        $categorie->setTotalnbblog($totalnbblog);
        $em->persist($categorie);
        $md = $em->getClassMetadata(get_class($categorie));
        $uow->computeChangeSet($md, $categorie);
    }
}
