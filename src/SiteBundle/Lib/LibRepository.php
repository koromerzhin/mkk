<?php

namespace Mkk\SiteBundle\Lib;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

class LibRepository extends EntityRepository
{
    protected $bundle;
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * Description of what this does.
     *
     * @param EntityManager $enM           EntityManager
     * @param mixedMetadata $classMetadata ClassMetadata
     */
    public function __construct(EntityManager $enM, ClassMetadata $classMetadata)
    {
        parent::__construct($enM, $classMetadata);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * Génération du li (pour faire la requête).
     *
     * @param string $entityName entityName
     *
     * @return void
     */
    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    /**
     * Permet de faire la requete.
     *
     * @param string $bundle MachinSiteBundle par exemple
     *
     * @return void
     */
    public function setBundle($bundle): void
    {
        $this->bundle = $bundle;
    }

    /**
     * Génére la query.
     *
     * @param string $dql   "SELECT i FROM NameSpace:Table"
     * @param array  $param tableau pour la requete
     *
     * @return Query
     */
    public function getQuery(string $dql, $param = []): Query
    {
        $query = $this->entityManager->createQuery($dql);
        if (0 !== count($param)) {
            $query->setParameters($param);
        }

        return $query;
    }

    /**
     * Faire la requete.
     *
     * @param array  $recherche ligne à
     *                          modifier
     * @param string $dql       DOCTRINE QUERY LANGUAGE
     *
     * @return string
     */
    public function searchImplode(array $recherche, string $dql): string
    {
        if (0 !== count($recherche)) {
            $dqlrecherche = '';
            foreach ($recherche as $search) {
                if ('' !== $dqlrecherche) {
                    $dqlrecherche = $dqlrecherche . ' AND ';
                }

                $dqlrecherche = $dqlrecherche . ' ' . $search;
            }

            $dql = "{$dql} WHERE " . trim($dqlrecherche);
        }

        return $dql;
    }

    /**
     * Execute la requete.
     *
     * @param string $dql   DOCTRINE QUERY LANGUAGE
     * @param array  $param param
     *
     * @return Query
     */
    public function setSearchResult($dql, $param = []): Query
    {
        $em    = $this->getEntityManager();
        $query = $em->createQuery($dql);
        if (0 !== count($param)) {
            $query->setParameters($param);
        }

        $result = $query;

        return $result;
    }

    /**
     * Donne le nom de l'entité.
     *
     * @return string
     */
    protected function getEntityName(): string
    {
        return (string) $this->entityName;
    }
}
