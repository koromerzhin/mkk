<?php

namespace Mkk\SiteBundle\DatabaseListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class UserDatabaseListener extends LibDatabaseListener
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
        $userManager = $container->get('bdd.user_manager');
        $userEntity  = $userManager->getTable();
        if ($this->entityInstanceofUpdate($userEntity)) {
            $this->onFlushTable($this->entity);
        }

        if ($this->entityInstanceofDelete($userEntity)) {
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
        $em      = $this->em;
        $uow     = $this->uow;
        $group   = $entity->getRefGroup();
        $methods = get_class_methods($group);
        if (is_array($methods) && in_array('getUsers', $methods)) {
            $users = $group->getUsers();
            $total = count($users) - 1;
            $group->setTotalnbuser($total);
            $em->persist($group);
            $md = $em->getClassMetadata(get_class($group));
            $uow->computeChangeSet($md, $group);
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
        $em            = $this->em;
        $uow           = $this->uow;
        $group         = $entity->getRefGroup();
        $methods       = get_class_methods($group);
        $plainPassword = $entity->getPlainPassword();

        if (0 !== strlen($plainPassword)) {
            $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
            $entity->setSalt($salt);
            $encoder        = $this->container->get('security.encoder_factory')->getEncoder($entity);
            $hashedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
            $entity->setPassword($hashedPassword);
            $entity->eraseCredentials();
        }

        if (is_array($methods) && in_array('getUsers', $methods)) {
            $users = $group->getUsers();
            $total = count($users);
            $group->setTotalnbuser($total);
            $em->persist($group);
            $md = $em->getClassMetadata(get_class($group));
            $uow->computeChangeSet($md, $group);
        }
    }
}
