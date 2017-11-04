<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Lib\LibController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class FileManagerController extends LibController
{
    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setTitre('File Manager');
    }

    /**
     * @Route("/fichiers", name="admin.filemanager.fichier")
     *
     * @return Response
     */
    public function fichier(): Response
    {
        $breadcrumb = [
            'libelle' => 'Fichiers',
            'url'     => 'admin.filemanager.fichier',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $url    = $this->getFileManager();
        $render = $this->render(
            'MkkAdminBundle:FileManager:index.html.twig',
            [
                'urlfilemanager' => $url,
            ]
        );

        return $render;
    }

    /**
     * @Route("/dossiers", name="admin.filemanager.dossier")
     *
     * @return Response
     */
    public function dossier(): Response
    {
        $breadcrumb = [
            'libelle' => 'Dossiers',
            'url'     => 'admin.filemanager.dossier',
        ];
        $this->breadcrumbService->add($breadcrumb);
        $url    = $this->getFileManager('documents');
        $render = $this->render(
            'MkkAdminBundle:FileManager:index.html.twig',
            [
                'urlfilemanager' => $url,
            ]
        );

        return $render;
    }

    /**
     * Récupére l'url du file manager.
     *
     * @param string $folder Si remplit, utilise le dossier en question
     *
     * @return string
     */
    private function getFileManager(string $folder = ''): string
    {
        $filename = $this->request->server->get('SCRIPT_FILENAME');
        $url      = str_replace(['app.php', 'app_dev.php', '/web/'], '', $filename);
        $url      = substr($url, strrpos($url, '/') + 1);
        $urlsite  = $this->request->getSchemeAndHttpHost() . $this->get('router')->getContext()->getBaseUrl();
        $code     = "48tp6QNp{$url}" . date('m/Y');
        if ('' !== $folder) {
            $code = "{$code}dir={$folder}";
        }

        $md5      = md5($code);
        $locale   = $this->request->getLocale();
        $fichiers = glob('filemanager/lang/*.php');
        $fichier  = 'filemanager/lang/fr_FR.php';
        foreach ($fichiers as $file) {
            if (substr_count($file, $locale)) {
                $fichier = $file;
                break;
            }
        }

        $lang    = str_replace(['filemanager/lang/', '.php'], '', $fichier);
        $urlsite = "{$urlsite}/filemanager/dialog.php?type=0&lang={$lang}&popup=0&crossdomain=0&akey={$md5}";

        return $urlsite;
    }
}
