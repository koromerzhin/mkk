<?php

namespace Mkk\SiteBundle\Service;

use Doctrine\ORM\Query;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SearchService
{
    /**
     * @var LibRepository
     */
    protected $repository;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var TableService
     */
    private $manager;
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var string
     */
    private $defaultSort;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $defaultDirection;

    /**
     * Init.
     *
     * @param ContainerInterface $container DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container        = $container;
        $this->params           = $container->get(ParamService::class)->listing();
        $this->requestStack     = $container->get('request_stack');
        $this->paginator        = $container->get('knp_paginator');
        $this->defaultSort      = 'id';
        $this->defaultDirection = 'asc';
        $this->request          = $this->requestStack->getCurrentRequest();
    }

    /**
     * Gestion du sort par défaut.
     *
     * @param string $sort ASC ou DESC
     *
     * @return void
     */
    public function setDefaultSort($sort): void
    {
        $this->defaultSort = 'li.' . $sort;
    }

    /**
     * Gestion de la direction par défaut.
     *
     * @param string $direction string
     *
     * @return void
     */
    public function setDefaultDirection($direction): void
    {
        $this->defaultDirection = $direction;
    }

    /**
     * Indique le manager.
     *
     * @param mixed $manager pour savoir quel table utiliser
     *
     * @return void
     */
    public function setManager($manager): void
    {
        $this->manager    = $this->container->get($manager);
        $this->repository = $this->manager->getRepository();
    }

    /**
     * Retour search.
     *
     * @param string $fonction fonction a appelé
     *
     * @return array
     */
    public function getResponse($fonction): array
    {
        $request               = $this->request;
        $container             = $this->container;
        $data                  = [];
        $id                    = $request->request->get('id');
        $data['lettre']        = $request->query->get('lettre');
        $token                 = $container->get('security.token_storage')->getToken();
        $data['user']          = $token->getUser();
        $data['params_config'] = $this->params;
        if ('' !== (string) $id) {
            $responsejson = $this->getResponseId($id);
        } else {
            $responsejson = $this->getResponseAll($fonction, $data);
        }

        return $responsejson;
    }

    /**
     * get Résultat.
     *
     * @param int $id Identifiant
     *
     * @return array
     */
    private function getResponseId($id): array
    {
        $responsejson = [];
        if (0 === substr_count($id, ',')) {
            $entity = $this->repository->find($id);
            if ($entity) {
                $methods = get_class_methods($entity);
                $this->manager->refresh($entity);
                if (!in_array('getSearchData', $methods)) {
                    $responsejson['error'] = 'Fonction getSearchData nom présent dans ' . get_class($entity);
                } else {
                    $responsejson = $entity->getSearchData();
                }
            }
        } else {
            $tab = explode(',', $id);
            foreach ($tab as $id) {
                $entity = $this->repository->find($id);
                if ($entity) {
                    $methods = get_class_methods($entity);
                    $this->manager->refresh($entity);
                    if (!in_array('getSearchData', $methods)) {
                        $responsejson['error'] = 'Fonction getSearchData nom présent dans ' . get_class($entity);
                    } else {
                        $responsejson[] = $entity->getSearchData();
                    }
                }
            }
        }

        return $responsejson;
    }

    /**
     * getData resultat.
     *
     * @param string $fonction fonction
     * @param array  $data     data
     *
     * @return array
     *
     * @author
     * @copyright
     */
    private function getResponseAll($fonction, $data): array
    {
        $required                = $this->request->query->get('required');
        $placeholder             = $this->request->query->get('placeholder');
        $responsejson            = [];
        $methods                 = get_class_methods($this->repository);
        $responsejson['results'] = [];
        $responsejson['total']   = 0;
        if (in_array($fonction, $methods)) {
            $query     = call_user_func_array([$this->repository, $fonction], $data);
            $paginator = $this->setPaginator($query);
            if (1 === $paginator->getPage() && 0 === $required) {
                $responsejson['results'][] = [
                    'id'  => '',
                    'nom' => $placeholder,
                ];
            }

            foreach ($paginator as $entity) {
                $methods = get_class_methods($entity);
                if (!in_array('getSearchData', $methods)) {
                    $responsejson['error'] = 'Fonction getSearchData nom présent dans ' . get_class($entity);
                    break;
                }

                $responsejson['results'][] = $entity->getSearchData();
            }

            $responsejson['total'] = $paginator->getTotalItemCount();
        } else {
            $responsejson['error'] = 'Fonction ' . $fonction . ' nom présent dans ' . get_class($this->repository);
        }

        return $responsejson;
    }

    /**
     * Génére la pagination.
     *
     * @param Query $query d'après EntityManager
     *
     * @return SlidingPagination
     */
    private function setPaginator(Query $query): SlidingPagination
    {
        $param = $this->params;
        $route = $this->request->get('_route');
        $limit = $this->setLimitDefault();

        list($module) = explode('_', $route);
        if (isset($param['module_listing'])) {
            foreach ($param['module_listing'] as $tab) {
                if ($tab['module'] === $module) {
                    $limit = $tab['val'];
                }
            }
        }

        if (0 !== (int) $this->request->query->get('limit')) {
            $limit = (int) $this->request->query->get('limit');
        }

        $page = (int) $this->request->get('page');
        if ($page <= 0) {
            $page = 1;
        }

        $pagination = $this->paginator->paginate(
            $query, // query NOT result
            $page/*page number*/,
            $limit// limit per page
        );
        if (!$this->request->query->get('sort') && !$this->request->query->get('direction')) {
            $pagination->setParam('sort', $this->defaultSort);
            $pagination->setParam('direction', $this->defaultDirection);
        }

        $route = $pagination->getRoute();
        $pagination->setUsedRoute($route);

        return $pagination;
    }

    /**
     * Donne la limit max pour les paginations.
     *
     * @return int
     */
    private function setLimitDefault(): int
    {
        $param = $this->params;
        $route = $this->request->get('_route');
        $limit = 50;
        if (0 !== substr_count($route, 'admin.') && isset($param['longueurliste']) && 0 !== $param['longueurliste']) {
            $limit = $param['longueurliste'];
        }

        if (0 === substr_count($route, 'admin.') && isset($param['publicliste']) && 0 !== $param['publicliste']) {
            $limit = $param['publicliste'];
        }

        return $limit;
    }
}
