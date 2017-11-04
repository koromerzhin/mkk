<?php

namespace Mkk\AdminBundle\Controller\Contact;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/contact/search/group", name="admin.contact.search.group")
     *
     * @return JsonResponse
     */
    public function contactSearchGroupAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.group_manager');
        $response = $searchService->getResponse('searchGroupContact');
        $json     = new JsonResponse($response);

        return $json;
    }
}
