<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityDiaporama
{
    /**
     * @var int
     *
     * @ORM\Column(name="diaporama_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="diaporama_nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var array
     *
     * @ORM\Column(name="diaporama_images", type="array", nullable=true)
     */
    protected $images;

    /**
     * @UploadableField(filename="images", path="diaporama/images", unique=false, alias="nom")
     */
    protected $fileImages;

    /**
     * @var string
     *
     * @ORM\Column(name="diaporama_totalnbimage", type="integer", options={"default": 0})
     */
    protected $totalnbimage;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Init de l'entité.
     */
    public function __construct()
    {
        $this->images       = [];
        $this->totalnbimage = 0;
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getNom();

        return $return;
    }

    /**
     * get id.
     *
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * Set nom.
     *
     * @param string $nom string
     *
     * @return self
     */
    public function setNom($nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * get nom.
     *
     * @return string
     */
    public function getNom(): string
    {
        return (string) $this->nom;
    }

    /**
     * Set images.
     *
     * @param array $images tableau des images
     *
     * @return self
     */
    public function setImages($images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * get images.
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * get the value of Totalnbimage.
     *
     * @return string
     */
    public function getTotalnbimage(): string
    {
        return (string) $this->totalnbimage;
    }

    /**
     * Set the value of Totalnbimage.
     *
     * @param string $totalnbimage int
     *
     * @return self
     */
    public function setTotalnbimage($totalnbimage): self
    {
        $this->totalnbimage = $totalnbimage;

        return $this;
    }

    /**
     * Get the value of Updated At.
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At.
     *
     * @param DateTime $updatedAt date
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of File Images.
     *
     * @return string
     */
    public function getFileImages(): string
    {
        return (string) $this->fileImages;
    }

    /**
     * Set the value of File Images.
     *
     * @param string $fileImages code MD5
     *
     * @return self
     */
    public function setFileImages(string $fileImages): self
    {
        $this->fileImages = $fileImages;

        return $this;
    }
}
