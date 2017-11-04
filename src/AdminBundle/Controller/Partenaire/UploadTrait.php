<?php

namespace Mkk\AdminBundle\Controller\Partenaire;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/partenaire/image/{md5}", name="admin.partenaire.upload.image")
     *
     * Upload d'une image d'un partenaire
     *
     * @return Response
     */
    public function partenaireImageAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
