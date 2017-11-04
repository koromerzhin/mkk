<?php

namespace Mkk\AdminBundle\Controller\Param;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/param/search/group", name="admin.param.search.group")
     *
     * @return JsonResponse
     */
    public function paramSearchGroupAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.group_manager');
        $response = $searchService->getResponse('searchGroupAll');
        $json     = new JsonResponse($response);

        return $json;
    }
}
