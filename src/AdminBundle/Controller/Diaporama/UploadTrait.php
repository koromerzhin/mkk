<?php

namespace Mkk\AdminBundle\Controller\Diaporama;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/diaporama/upload/images/{md5}", name="admin.diaporama.upload.images")
     *
     * @return Response
     */
    public function diaporamaImagesAction(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
