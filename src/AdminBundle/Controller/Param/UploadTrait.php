<?php

namespace Mkk\AdminBundle\Controller\Param;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/param/upload/login/{md5}", name="admin.param.upload.login")
     *
     * @return Response
     */
    public function paramLoginAction(): Response
    {
        $options = [
            'image_versions' => [],
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/param/upload/googlemaps/{md5}", name="admin.param.upload.googlemaps")
     *
     * @return Response
     */
    public function paramGoogleMapsAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
            'image_versions'      => [],
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/param/upload/avatar/{md5}", name="admin.param.upload.avatar")
     *
     * @return Response
     */
    public function paramAvatarAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
            'image_versions'      => [],
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/param/upload/logo/{md5}", name="admin.param.upload.logo")
     *
     * @return Response
     */
    public function paramLogoAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/param/upload/logobackend/{md5}", name="admin.param.upload.logobackend")
     *
     * @return Response
     */
    public function paramLogobackendAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/param/upload/favicon/{md5}", name="admin.param.upload.favicon")
     *
     * @return Response
     */
    public function paramFaviconAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
