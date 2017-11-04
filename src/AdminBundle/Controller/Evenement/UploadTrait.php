<?php

namespace Mkk\AdminBundle\Controller\Evenement;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/evenement/galerie/{md5}", name="admin.evenement.upload.galerie")
     *
     * @return Response
     */
    public function evenementgalerieAction(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/evenement/vignette/{md5}", name="admin.evenement.upload.vignette")
     *
     * @return Response
     */
    public function evenementvignetteAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
