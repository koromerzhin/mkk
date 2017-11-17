<?php

namespace Mkk\SiteBundle\Service;

use Doctrine\Common\Annotations\Reader;
use Mkk\SiteBundle\Annotation\UploadableField;

class AnnotationReaderService
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * Génération service.
     *
     * @param Reader $reader Reader annotation
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Récupére les champs uploadable.
     *
     * @param mixed $entity Class Table
     *
     * @return array
     */
    public function getUploadableFields($entity): array
    {
        $tab        = [];
        $reflection = new \ReflectionClass(get_class($entity));
        foreach ($reflection->getProperties() as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, UploadableField::class);
            if (NULL !== $annotation) {
                $name       = $property->getName();
                $tab[$name] = $annotation;
            }
        }

        return $tab;
    }
}
