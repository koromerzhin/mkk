<?php

namespace Mkk\AdminBundle\Controller\Moncompte;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/moncompte/upload/avatar/{md5}", name="admin.profil.upload.avatar")
     * Gestion de l'avatar de l'utilisateur actuel
     *
     * @return Response
     */
    public function avatarAction(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
