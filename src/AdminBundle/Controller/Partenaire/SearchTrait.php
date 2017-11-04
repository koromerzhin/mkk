<?php

namespace Mkk\AdminBundle\Controller\Partenaire;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/partenaire/search/categorie", name="admin.partenaire.search.categorie")
     *
     * @return JsonResponse
     */
    public function partenaireSearchCategorieAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.categorie_manager');
        $response = $searchService->getResponse('searchCategoriePartenaire');
        $json     = new JsonResponse($response);

        return $json;
    }
}
