<?php

namespace Mkk\AdminBundle\Controller\Page;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/image/{md5}", name="admin.page.upload.avatarimage")
     * @Route("/fondimage/{md5}", name="admin.page.upload.avatarfondimage")
     * @Route("/filigramme/{md5}", name="admin.page.upload.avatarfiligramme")
     *
     * @return Response
     */
    public function uploadimageAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/video/{md5}", name="admin.page.upload.avatarvideo")
     *
     * @return Response
     */
    public function uploadvideoAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
            'upload_video'        => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/galerie/{md5}", name="admin.page.upload.avatargalerie")
     *
     * @return Response
     */
    public function uploadgalerieAction(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
