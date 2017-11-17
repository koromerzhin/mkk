<?php

namespace Mkk\AdminBundle\Controller\NoteInterne;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/noteinterne/search/user", name="admin.noteinterne.search.user")
     *
     * Liste des utilisateurs pour le moteur de recherche des notes internes
     *
     * @return JsonResponse
     */
    public function noteInterneSearchUserAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.user_manager');
        $response = $searchService->getResponse('searchUserConnect');
        $json     = new JsonResponse($response);

        return $json;
    }

    /**
     * @Route("/noteinterne/search/group", name="admin.noteinterne.search.group")
     *
     * Liste des groupes pour le moteur de recherche des notes internes
     *
     * @return JsonResponse
     */
    public function noteInterneSearchGroupAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.group_manager');
        $response = $searchService->getResponse('searchGroupConnect');
        $json     = new JsonResponse($response);

        return $json;
    }

    /**
     * @Route("/noteinterne/search/etablissement", name="admin.noteinterne.search.etablissement")
     *
     * Liste des établissements pour le moteur de recherche des notes internes
     *
     * @return JsonResponse
     */
    public function noteInterneSearchEtablissementAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.etablissement_manager');
        $response = $searchService->getResponse('searchEtablissement');
        $json     = new JsonResponse($response);

        return $json;
    }
}
