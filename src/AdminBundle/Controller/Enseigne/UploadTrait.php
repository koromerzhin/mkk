<?php

namespace Mkk\AdminBundle\Controller\Enseigne;

use Mkk\SiteBundle\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

trait UploadTrait
{
    /**
     * @Route("/etablissements/vignette/{md5}", name="admin.enseigne.upload.vignette")
     *
     * Description of what this does.
     *
     * @return Response
     */
    public function vignetteEtablissement(): Response
    {
        $options = [
            'max_number_of_files' => 1,
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/etablissements/vuesexterne/{md5}", name="admin.enseigne.upload.vuesexterne")
     *
     * Description of what this does.
     *
     * @return Response
     */
    public function vuesexterneEtablissement(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/etablissements/vuesinterne/{md5}", name="admin.enseigne.upload.vuesinterne")
     *
     * Description of what this does.
     *
     * @return Response
     */
    public function vuesinterneEtablissement(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/etablissements/galerie/{md5}", name="admin.enseigne.upload.galerie")
     *
     * Description of what this does.
     *
     * @return Response
     */
    public function galerieEtablissement(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/etablissements/pdf/{md5}", name="admin.enseigne.upload.pdf")
     *
     * Affiche le pdf des etablissements
     *
     * @return Response
     */
    public function pdfEtablissement(): Response
    {
        $options = [
            'accept_file_types' => 'pdf',
        ];

        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }

    /**
     * @Route("/etablissements/vuesequipe/{md5}", name="admin.enseigne.upload.vuesequipe")
     *
     * Description of what this does.
     *
     * @return Response
     */
    public function vuesequipeEtablissement(): Response
    {
        $options  = [];
        $retour   = $this->get(UploadService::class)->ajax($options);
        $response = new Response($retour);

        return $response;
    }
}
