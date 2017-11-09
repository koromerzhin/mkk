<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;

class DroitService
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var TableService
     */
    private $manager;

    private $repository;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->router       = $container->get('router');
        $this->requestStack = $container->get('request_stack');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->manager      = $this->container->get('bdd.action_manager');
        $this->repository   = $this->manager->getRepository();
    }

        /**
         * Donne les routes à utiliser pour les droits
         *
         * @return    array
         */
    public function getRoute(): array
    {
        $routes            = $this->router->getRouteCollection()->all();
        $data              = [];
        $disableRouteDroit = [
                'scripts.upload',
                'scripts.forgot',
                'scripts.login',
                'scripts.disable',
                'scripts.nojs',
                'scripts.telephone',
                'scripts.cpville',
                'scripts.wysiwyg',
            ];
        foreach ($routes as $name => $route) {
            $pattern = $route->getPath();
            $test1   = 0 === (int) substr_count($name, '_');
            $test2   = !in_array($name, $disableRouteDroit);
            if ($test1 && $test2) {
                $data[$name] = $pattern;
            }
        }

        return $data;
    }

    /**
     * Supprimer les anciens droits.
     *
     * @return void
     */
    public function supprimer(): void
    {
        $dataAllRoute = $this->getRoute();
        $supprimer    = [];
        $entity       = $this->repository->findAllRoute();
        foreach ($entity as $row) {
            $route = $row['route'];
            if (!in_array($route, $dataAllRoute)) {
                $supprimer[] = $route;
            }
        }

        $batchSize = 5;
        $i         = 0;
        foreach ($supprimer as $route) {
            $entities = $this->repository->findByRoute($route);
            foreach ($entities as $entity) {
                $this->manager->remove($entity);
                ++$i;
                if (0 === ($i % $batchSize)) {
                    $this->manager->flush();
                }
            }
        }

        $this->manager->flush();
    }

        /**
         * Ajoute les droits pour le groupe
         *
         * @param     entity $group group
         * @return    void
         */
    public function add($group): void
    {
        $entityGroup = $this->manager->getTable();
        $routes      = $this->getRoute();
        $add         = [];
        foreach (array_keys($routes) as $route) {
            $continuer = 0;
            if ('visiteur' === $group->getCode()) {
                if (0 === substr_count($route, 'admin.')) {
                    $continuer = 1;
                }
            } else {
                $continuer = 1;
            }

            if (1 === $continuer) {
                $search = [
                        'refgroup' => $group,
                        'route'    => $route,
                ];

                $entity = $this->repository->findOneBy($search);
                if (!$entity) {
                    $add[] = $search;
                }
            }
        }

        $batchSize = 5;
        foreach ($add as $i => $row) {
            $entity = new $entityGroup();
            $entity->setRefgroup($row['refgroup']);
            $entity->setRoute($row['route']);
            $etat = 0 === substr_count($row['route'], 'admin.') ? 1 : 0;
            $entity->setEtat($etat);
            $this->manager->persist($entity);
            ++$i;
            if (0 === ($i % $batchSize)) {
                $this->manager->flush();
            }
        }

        $this->manager->flush();
    }
}
