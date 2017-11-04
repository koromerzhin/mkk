<?php

namespace Mkk\AdminBundle\Controller\Bookmark;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/bookmark/image/{md5}", name="admin.bookmark.upload.image")
     *
     * Upload d'une image d'un article du blog
     *
     * @return Response
     */
    public function bookmarkImageAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
