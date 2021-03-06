<?php

namespace Mkk\SiteBundle\Repository;

use Doctrine\ORM\Query;
use Mkk\SiteBundle\Lib\LibTranslatableRepository;

class RepositoryEdito extends LibTranslatableRepository
{
    /**
     * requete pour la liste d'admin.
     *
     * @return Query
     */
    public function searchAdminList(): Query
    {
        $entity = $this->getEntityName();
        $dql    = "SELECT {$entity} FROM {$this->bundle}:Edito {$entity}";
        $query  = $this->getQuery($dql);

        return $query;
    }

    /**
     * Return le nombre de données.
     *
     * @return array
     */
    public function totalWidgetList(): array
    {
        $entity = $this->getEntityName();
        $dql    = "SELECT COUNT({$entity}) AS total FROM {$this->bundle}:Edito {$entity}";
        $query  = $this->getQuery($dql);
        $result = $query->getArrayResult();

        return $result;
    }

    /**
     * Return les 5 derniers résultats.
     *
     * @return array
     */
    public function searchWidgetList(): array
    {
        $entity = $this->getEntityName();
        $dql    = "SELECT {$entity} FROM {$this->bundle}:Edito {$entity} ORDER BY {$entity}.id desc";
        $query  = $this->getQuery($dql);
        $query->setMaxResults(5);
        $result = $query->getResult();

        return $result;
    }
}
