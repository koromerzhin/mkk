<?php

namespace Mkk\AdminBundle\Controller\Edito;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/edito/search/redacteur", name="admin.edito.search.redacteur")
     *
     * @return JsonResponse
     */
    public function editoSearchRedacteurAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.user_manager');
        $response = $searchService->getResponse('searchUserConnect');
        $json     = new JsonResponse($response);

        return $json;
    }
}
