<?php

namespace Mkk\SiteBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Mkk\SiteBundle\Lib\LibDatabaseListener;

class DatabaseListener extends LibDatabaseListener
{
    /**
     * Listener on flush.
     *
     * @param OnFlushEventArgs $args arguments
     *
     * @return void
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        $servicesID = $this->container->getServiceIds();
        foreach ($servicesID as $service) {
            if (0 !== substr_count($service, "\DatabaseLister")) {
                $listener = $this->container->get($service);
                $listener->launch($args);
            }
        }
    }
}
