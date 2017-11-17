<?php

namespace Mkk\AdminBundle\Controller\Blog;

use Mkk\SiteBundle\Service\SearchService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

trait SearchTrait
{
    /**
     * @Route("/blog/search/categorie", name="admin.blog.search.categorie")
     *
     * @return JsonResponse
     */
    public function blogSearchCategorieAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.categorie_manager');
        $response = $searchService->getResponse('searchCategorieBlog');
        $json     = new JsonResponse($response);

        return $json;
    }

    /**
     * @Route("/blog/search/redacteur", name="admin.blog.search.redacteur")
     *
     * @return JsonResponse
     */
    public function blogSearchRedacteurAction(): JsonResponse
    {
        $searchService = $this->get(SearchService::class);
        $searchService->setManager('bdd.user_manager');
        $response = $searchService->getResponse('searchUserConnect');
        $json     = new JsonResponse($response);

        return $json;
    }
}
