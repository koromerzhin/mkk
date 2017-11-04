<?php

namespace Mkk\SiteBundle\Handler;

use Mkk\SiteBundle\Service\UploadService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UploadHandler
{
    /**
     * @var UploadService
     */
    protected $uploadService;

    private $accessor;

    private $container;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->accessor  = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Remplit le champs uploadFile avec les données du dossier md5
     * Uniquement si le champs md5 est remplit.
     *
     * @param mixed $entity     Entité
     *                          table
     * @param mixed $property   Champs à
     *                          remplir
     * @param mixed $annotation Annotation
     *
     * @return void
     */
    public function uploadFile($entity, $property, $annotation): void
    {
        $md5 = $this->accessor->getValue($entity, $property);
        if ('' !== $md5) {
            $this->uploadService = $this->container->get(UploadService::class);
            $recuperer           = $this->uploadService->get($md5);
            $data                = $this->uploadService->move($recuperer, $entity, $this->accessor, $annotation);
            $this->accessor->setValue($entity, $annotation->getFilename(), $data);
        }
    }

    /**
     * Supprimer les anciens fichiers présent sur le site (WIP).
     *
     * @param mixed $entity     Entité
     *                          table
     * @param mixed $annotation Annotation
     *
     * @return void
     */
    public function removeOldFile($entity, $annotation): void
    {
        $filename = $this->accessor->getValue($entity, $annotation->getFilename());
        if ('' === $filename) {
            return;
        }

        if (is_array($filename)) {
            $data = $filename;
        } else {
            $data = json_decode($filename, TRUE);
            if (!is_array($data)) {
                $data = [$filename];
            }
        }

        foreach ($data as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Supprimer les fichiers et le dossier md5.
     *
     * @param mixed $entity   Entité
     *                        table
     * @param mixed $property Champs a remplir
     *
     * @return void
     */
    public function removeMD5FolderFile($entity, $property): void
    {
        $md5 = $this->accessor->getValue($entity, $property);
        dump($md5);
    }

    /**
     * Indique un code md5 pour le champs de type UploadateField.
     *
     * @param mixed $entity     Entité
     *                          Table
     * @param mixed $property   Champs a remplir
     * @param mixed $annotation Annotation
     *
     * @return void
     */
    public function setFileFromFilename($entity, $property, $annotation): void
    {
        $md5 = $this->getFileFromFilename($entity, $annotation);
        $this->accessor->setValue($entity, $property, $md5);
    }

    /**
     * Supprime le contenu du dossier.
     *
     * @param string $dir dossier
     *
     * @return void
     */
    private function delTree(string $dir): void
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("{$dir}/{$file}")) ? $this->delTree("{$dir}/{$file}") : unlink("{$dir}/{$file}");
        }

        rmdir($dir);
    }

    /**
     * Initalise le md5.
     *
     * @param mixed $entity     Entité
     *                          Table
     * @param mixed $annotation Liste des annotatation
     *
     * @return string
     *
     * @author
     * @copyright
     */
    private function getFileFromFilename($entity, $annotation): string
    {
        $filename = $this->accessor->getValue($entity, $annotation->getFilename());
        $md5      = md5(uniqid(NULL, TRUE));
        $this->container->get(UploadService::class)->init($md5, $filename);

        return $md5;
    }
}
