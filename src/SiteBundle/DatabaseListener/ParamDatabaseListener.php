<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class ParamDatabaseListener extends LibDatabaseListener
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
        $container    = $this->container;
        $paramManager = $container->get('bdd.param_manager');
        $paramEntity  = $paramManager->getTable();
        if ($this->entityInstanceofUpdate($paramEntity)) {
            $this->onFlushTable($this->entity);
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
        $code   = $entity->getCode();
        $valeur = $entity->getValeur();
        if ('robotstxt' === $code) {
            file_put_contents('robots.txt', $valeur);
        } elseif ('crontab' === $code) {
            file_put_contents('crontab.sh', $valeur);
        }
    }
}
