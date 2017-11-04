<?php

namespace Mkk\SiteBundle\Lib;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Psr\Container\ContainerInterface;

class LibDatabaseListener implements EventSubscriber
{
    protected $kernel;
    protected $container;
    protected $em;
    protected $entities;
    protected $entity;

    /**
     * Init.
     *
     * @param ContainerInterface $container DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->kernel    = $container->get('kernel');
        $this->container = $this->kernel->getContainer();
    }

    /**
     * Sur quoi écouter.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            'onFlush',
        ];
    }

    /**
     * Savoir si l'on utilise la table est en mode delete.
     *
     *
     * @param mixed $entity entité
     *
     * @return bool
     */
    public function entityInstanceofDelete($entity): bool
    {
        $retour = FALSE;
        $total  = count($this->delete);
        if (0 !== $total) {
            foreach ($this->delete as $row) {
                if (get_class($row) === $entity) {
                    $this->entity = $row;
                    $retour       = TRUE;
                    break;
                }
            }
        }

        return $retour;
    }

    /**
     * Savoir si l'on utilise la table est en mode update.
     *
     * @param mixed $entity entité
     *
     * @return bool
     */
    public function entityInstanceofUpdate($entity): bool
    {
        $retour = FALSE;
        $total  = count($this->update);
        if (0 !== $total) {
            foreach ($this->update as $row) {
                if (get_class($row) === $entity) {
                    $this->entity = $row;
                    $retour       = TRUE;
                    break;
                }
            }
        }

        return $retour;
    }

    /**
     * Description of what this does.
     *
     * @param OnFlushEventArgs $args arguments
     *
     * @return void
     */
    public function setVarargs(OnFlushEventArgs $args): void
    {
        $em        = $args->getEntityManager();
        $this->em  = $em;
        $uow       = $em->getUnitOfWork();
        $this->uow = $uow;
        $update    = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        $this->update = $update;
        $delete       = $uow->getScheduledEntityDeletions();
        $this->delete = $delete;
        $entities     = array_merge(
            $update,
            $delete
        );

        $this->entities = $entities;
    }
}
