<?php

namespace Mkk\AdminBundle\Controller\Blog;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/blog/vignette/{md5}", name="admin.blog.upload.vignette")
     *
     * Upload d'une vignette d'un article du blog
     *
     * @return Response
     */
    public function blogVignetteAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/blog/image/{md5}", name="admin.blog.upload.image")
     *
     * Upload d'une image d'un article du blog
     *
     * @return Response
     */
    public function blogImageAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/blog/galerie/{md5}", name="admin.blog.upload.galerie")
     *
     * Upload d'une ou plusieurs images d'un article du blog
     *
     * @return Response
     */
    public function blogGalerieAction(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
