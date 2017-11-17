<?php

namespace Mkk\SiteBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class UploadableField
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $unique; /**
     * @var string
     */
    private $alias;

    /**
     * Init.
     *
     * @param array $options data
     */
    public function __construct(array $options)
    {
        if (!isset($options['filename'])) {
            throw new \InvalidArgumentException("L'annotation UploadableField doit avoir un attribut filename");
        }

        if (!isset($options['path'])) {
            throw new \InvalidArgumentException("L'annotation UploadableField doit avoir un attribut path");
        }

        if (!isset($options['unique'])) {
            throw new \InvalidArgumentException("L'annotation UploadableField doit avoir un attribut unique");
        }

        if (!isset($options['alias'])) {
            throw new \InvalidArgumentException("L'annotation UploadableField doit avoir un attribut alias");
        }

        $this->alias    = $options['alias'];
        $this->unique   = $options['unique'];
        $this->filename = $options['filename'];
        $this->path     = $options['path'];
    }

    /**
     * Verifie si le champs est unique.
     *
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Get the value of Filename.
     *
     * @return mixed
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Get the value of Path.
     *
     * @return mixed
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the value of Alias.
     *
     * @return mixed
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
}
