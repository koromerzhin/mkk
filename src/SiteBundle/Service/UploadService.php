<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Annotation\UploadableField;
use Mkk\SiteBundle\Service\Traits\UploadTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\Router;

class UploadService
{
    use UploadTrait;
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $md5;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->md5          = [];
        $this->requestStack = $container->get('request_stack');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->router       = $container->get('router');
        $paramsService      = $container->get(ParamService::class);
        $this->params       = $paramsService->listing();
    }

    /**
     * Lancement du système d'upload de fichier
     * Utilise la librairie Externe UploadHandler.
     *
     * @param array $options options pour les fichiers
     *
     * @return string
     */
    public function ajax(array $options): string
    {
        $md5     = $this->setMd5();
        $options = $this->setOptions($md5);

        $folder = '../';
        if (is_dir('web')) {
            $folder = '';
        }

        if (!is_dir($options['upload_dir'])) {
            mkdir($options['upload_dir'], 0775, TRUE);
        }

        if (isset($options['thumbnail_dir']) && !is_dir($options['thumbnail_dir'])) {
            mkdir($options['thumbnail_dir'], 0775, TRUE);
        }

        error_reporting(E_ALL | E_STRICT);
        ob_start();
        $errorMessages = [
            1                     => 'The file exceeds the upload_max_filesize directive in php.ini',
            2                     => 'The file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3                     => 'The file was only partially uploaded',
            4                     => 'No file was uploaded',
            6                     => 'Missing a temporary folder',
            7                     => 'Failed to write file to disk',
            8                     => 'A PHP extension stopped the file upload',
            'post_max_size'       => 'The uploaded file exceeds the post_max_size directive in php.ini',
            'max_file_size'       => 'File is too big',
            'min_file_size'       => 'File is too small',
            'accept_file_types'   => 'Filetype not allowed',
            'max_number_of_files' => 'Maximum number of files exceeded',
            'max_width'           => 'Image exceeds maximum width',
            'min_width'           => 'Image requires a minimum width',
            'max_height'          => 'Image exceeds maximum height',
            'min_height'          => 'Image requires a minimum height',
        ];
        if ('' !== $folder) {
            $classfile = $folder . 'vendor/blueimp/jquery-file-upload/server/php/UploadHandler.php';
            require $classfile;
            $uploadHandler = new \UploadHandler($options, TRUE, $errorMessages);
        }

        $contenu = ob_get_contents();
        ob_end_clean();
        unset($uploadHandler);

        return $contenu;
    }

    /**
     * Récupére les md5.
     *
     * @return array
     */
    public function getMd5(): array
    {
        return $this->md5;
    }

    /**
     * Initialisation du dossier md5 avec les filename.
     *
     * @param string $md5      Code md5
     * @param mixed  $filename Code md5
     *
     * @return void
     */
    public function init($md5, $filename): void
    {
        if (is_array($filename)) {
            $data = $filename;
        } else {
            $data = json_decode($filename, TRUE);
            if (!is_array($data)) {
                $data = [$filename];
            }
        }

        $this->initFolderUpload($md5, $data);
        $this->md5 = 1;
    }

    /**
     * Déplace un fichier.
     *
     * @param array            $recuperer  liste des fichiers
     * @param mixed            $entity     Classe TABLE
     * @param PropertyAccessor $accessor   Classe PropertyAccessor
     * @param UploadableField  $annotation Classe UploadableField
     *
     * @return array|string suivant si le champs est unique ou pas
     *
     * @author
     * @copyright
     */
    public function move(array $recuperer, $entity, PropertyAccessor $accessor, UploadableField $annotation)
    {
        $request     = $this->request;
        $filename    = $request->server->get('filename');
        $emplacement = substr(dirname($filename) . '/fichiers/', 1);
        $finfo       = finfo_open(FILEINFO_MIME_TYPE);
        if ($annotation->isUnique()) {
            $data = '';
        } else {
            $data = [];
        }

        foreach ($recuperer as $i => $file) {
            $info                   = finfo_file($finfo, $file);
            list($type, $extension) = explode('/', $info);
            unset($type);
            $extension      = strtolower($extension);
            $alias          = $accessor->getValue($entity, $annotation->getAlias());
            $newemplacement = $emplacement;
            $entityName     = get_class($entity);
            $entityName     = substr($entityName, strrpos($entityName, '\\') + 1);
            $entityName     = strtolower($entityName);
            $newemplacement = $newemplacement . $entityName;
            $dirname        = $newemplacement . '/' . $annotation->getFilename();
            if (!is_dir($dirname)) {
                mkdir($dirname, 0775, TRUE);
            }

            if ($annotation->isUnique()) {
                $fichier = $dirname . '/' . $alias . '.' . $extension;
                $data    = $fichier;
                copy($file, $fichier);
            } else {
                $fichier = $dirname . '/' . $alias . $i . '.' . $extension;
                $data[]  = $fichier;
                copy($file, $fichier);
            }
        }

        return $data;
    }

    /**
     * Récupre la liste des fichiers présent dans le dossier $md5.
     *
     * @param string $md5 code md5
     *
     * @return array
     */
    public function get(string $md5): array
    {
        $filename    = $this->request->server->get('SCRIPT_FILENAME');
        $emplacement = dirname($filename);
        $data        = [];
        if (is_dir($emplacement . '/tmp/' . $md5)) {
            $fichiers = glob($emplacement . '/tmp/' . $md5 . '/*');
            foreach ($fichiers as $file) {
                if (is_file($file)) {
                    $data[] = $file;
                }
            }
        }

        return $data;
    }
}
