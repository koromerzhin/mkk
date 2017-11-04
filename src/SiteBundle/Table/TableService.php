<?php

namespace Mkk\SiteBundle\Table;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Gedmo\Translatable\Entity\Translation;
use Mkk\SiteBundle\Lib\LibRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class TableService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManagerInterface
     */
    private $entityMag;
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $repository;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $deftable;

    /**
     * @var TranslationRepository
     */
    private $translations;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     * @param string             $table     nom de la table
     */
    public function __construct(ContainerInterface $container, string $table)
    {
        $this->container = $container;
        $this->entityMag = $container->get('doctrine.orm.entity_manager');
        $this->kernel    = $container->get('kernel');
        $this->setTableInit($table);
        $this->translations = $this->entityMag->getRepository(Translation::class);
    }

    /**
     * Recupère la classe translations.
     *
     * @return TranslationRepository
     */
    public function getTranslations(): TranslationRepository
    {
        return $this->translations;
    }

    /**
     * Retourne la table.
     *
     * @return string
     */
    public function getTable(): string
    {
        if (!isset($this->table)) {
            throw new \Exception('Bug sur la liaison table ' . $this->deftable);
        }

        return $this->table;
    }

    /**
     * Flush la table.
     *
     * @return void
     */
    public function flush(): void
    {
        $this->entityMag->flush();
    }

    /**
     * Supprime la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function remove($entity): void
    {
        $this->entityMag->remove($entity);
    }

    /**
     * Detach la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function detach($entity): void
    {
        $this->entityMag->detach($entity);
    }

    /**
     * Rafraichi la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function refresh($entity): void
    {
        $this->entityMag->refresh($entity);
    }

    /**
     * Persist la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function persist($entity): void
    {
        $this->entityMag->persist($entity);
    }

    /**
     * Persist et flush la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function persistAndFlush($entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * Supprime et Flush la table.
     *
     * @param mixed $entity Class Table
     *
     * @return void
     */
    public function removeAndFlush($entity): void
    {
        $this->remove($entity);
        $this->flush();
    }

    /**
     * Retourne le repository.
     *
     * @return LibRepository
     */
    public function getRepository(): LibRepository
    {
        $return = $this->entityMag->getRepository($this->repository);
        $return->setEntityName('li');
        $return->setBundle($this->namespace . 'SiteBundle');

        return $return;
    }

    /**
     * Initialise la table.
     *
     * @param string $table Nom de la table
     *
     * @return void
     */
    private function setTableInit(string $table): void
    {
        foreach ($this->kernel->registerBundles() as $row) {
            $name = $row->getName();
            if (0 !== substr_count($name, 'SiteBundle') && 0 === substr_count($name, 'MkkSiteBundle')) {
                $namespace       = str_replace('SiteBundle', '', $name);
                $this->namespace = $namespace;
            }
        }

        $repository       = "{$namespace}SiteBundle:{$table}";
        $this->repository = $repository;
        $table            = "{$namespace}\SiteBundle\Entity\\{$table}";
        $this->setTable($table);
    }

    /**
     * Set table.
     *
     * @param string $table $table
     *
     * @return void
     */
    private function setTable(string $table): void
    {
        $this->table = $table;
    }
}
