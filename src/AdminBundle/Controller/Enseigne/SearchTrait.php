<?php

namespace Mkk\AdminBundle\Controller\Enseigne;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/etablissement/search/nafsousclasse", name="admin.enseigne.search.nafsousclasse")
     *
     * @return JsonResponse
     */
    public function etablissementSearchNafSousClasseAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.nafsousclasse_manager');
        $response = $searchService->getResponse('searchNafSousClasse');
        $json     = new JsonResponse($response);

        return $json;
    }
}
