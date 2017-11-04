<?php

namespace Mkk\AdminBundle\Controller\Evenement;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/evenement/search/categorie", name="admin.evenement.search.categorie")
     *
     * @return JsonResponse
     */
    public function evenementSearchCategorieAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.categorie_manager');
        $response = $searchService->getResponse('searchCategorieEvenement');
        $json     = new JsonResponse($response);

        return $json;
    }

    /**
     * @Route("/evenement/search/lieu", name="admin.evenement.search.lieu")
     *
     * @return JsonResponse
     */
    public function evenementSearchLieuAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.etablissement_manager');
        $response = $searchService->getResponse('searchEtablissementSaufEnseigne');
        $json     = new JsonResponse($response);

        return $json;
    }
}
