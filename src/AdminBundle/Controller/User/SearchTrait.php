<?php

namespace Mkk\AdminBundle\Controller\User;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/user/search/etablissement", name="admin.user.search.etablissement")
     *
     * @return JsonResponse
     */
    public function userSearchEtablissementAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.etablissement_manager');
        $response = $searchService->getResponse('searchEtablissement');
        $json     = new JsonResponse($response);

        return $json;
    }

    /**
     * @Route("/user/search/group", name="admin.user.search.group")
     *
     * @return JsonResponse
     */
    public function userSearchGroupAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.group_manager');
        $response = $searchService->getResponse('searchGroupConnect');
        $json     = new JsonResponse($response);

        return $json;
    }
}
