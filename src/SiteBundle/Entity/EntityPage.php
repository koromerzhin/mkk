<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityPage
{
    /**
     * @var int
     *
     * @ORM\Column(name="page_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="page_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="page_url", unique=true, type="string", length=255)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="page_contenu", type="text", nullable=true)
     */
    protected $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="page_css", type="text", nullable=true)
     */
    protected $css;

    /**
     * @var string
     *
     * @ORM\Column(name="page_image", type="text", nullable=true)
     */
    protected $image;

    /**
     * @UploadableField(filename="image", path="page/image", unique=true, alias="titre")
     */
    protected $fileImage;

    /**
     * @var string
     *
     * @ORM\Column(name="page_fondimage", type="text", nullable=true)
     */
    protected $fondimage;

    /**
     * @UploadableField(filename="fondimage", path="page/fondimage", unique=true, alias="titre")
     */
    protected $fileFondimage;

    /**
     * @var string
     *
     * @ORM\Column(name="page_filigramme", type="text", nullable=true)
     */
    protected $filigramme;

    /**
     * @UploadableField(filename="filigramme", path="page/filigramme", unique=true, alias="titre")
     */
    protected $fileFiligramme;

    /**
     * @var string
     *
     * @ORM\Column(name="page_video", type="text", nullable=true)
     */
    protected $video;

    /**
     * @UploadableField(filename="video", path="page/video", unique=true, alias="titre")
     */
    protected $fileVideo;

    /**
     * @var array
     *
     * @ORM\Column(name="page_galerie", type="array", nullable=true)
     */
    protected $galerie;

    /**
     * @UploadableField(filename="galerie", path="page/galerie", unique=false, alias="titre")
     */
    protected $fileGalerie;

    /**
     * @var string
     *
     * @ORM\Column(name="page_meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="page_meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;
    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getTitre();

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
     * Set titre.
     *
     * @param string $titre titre
     *
     * @return self
     */
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * get titre.
     *
     * @return string
     */
    public function getTitre(): string
    {
        return (string) $this->titre;
    }

    /**
     * Set url.
     *
     * @param string $url url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * get url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return (string) $this->url;
    }

    /**
     * Set contenu.
     *
     * @param string $contenu contenu
     *
     * @return self
     */
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * get contenu.
     *
     * @return string
     */
    public function getContenu(): string
    {
        return (string) $this->contenu;
    }

    /**
     * Set image.
     *
     * @param string $image image
     *
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * get image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return (string) $this->image;
    }

    /**
     * Set galerie.
     *
     * @param array $galerie galerie
     *
     * @return self
     */
    public function setGalerie(array $galerie): self
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * get galerie.
     *
     * @return array
     */
    public function getGalerie(): array
    {
        return (array) $this->galerie;
    }

    /**
     * get the value of Meta Description.
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return (string) $this->metaDescription;
    }

    /**
     * Set the value of Meta Description.
     *
     * @param mixed $metaDescription meta description
     *
     * @return self
     */
    public function setMetaDescription($metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * get the value of Meta Keywords.
     *
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return (string) $this->metaKeywords;
    }

    /**
     * Set the value of Meta Keywords.
     *
     * @param mixed $metaKeywords Meta keywords
     *
     * @return self
     */
    public function setMetaKeywords($metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get the value of Css.
     *
     * @return string
     */
    public function getCss(): string
    {
        return (string) $this->css;
    }

    /**
     * Set the value of Css.
     *
     * @param string $css css
     *
     * @return self
     */
    public function setCss(string $css): self
    {
        $this->css = $css;

        return $this;
    }

    /**
     * Get the value of Fondimage.
     *
     * @return string
     */
    public function getFondimage()
    {
        return $this->fondimage;
    }

    /**
     * Set the value of Fondimage.
     *
     * @param string $fondimage fond image
     *
     * @return self
     */
    public function setFondimage(string $fondimage): self
    {
        $this->fondimage = $fondimage;

        return $this;
    }

    /**
     * Get the value of Filigramme.
     *
     * @return string
     */
    public function getFiligramme(): string
    {
        return (string) $this->filigramme;
    }

    /**
     * Set the value of Filigramme.
     *
     * @param string $filigramme filigramme
     *
     * @return self
     */
    public function setFiligramme(string $filigramme): self
    {
        $this->filigramme = $filigramme;

        return $this;
    }

    /**
     * Get the value of Video.
     *
     * @return string
     */
    public function getVideo(): string
    {
        return (string) $this->video;
    }

    /**
     * Set the value of Video.
     *
     * @param string $video video
     *
     * @return self
     */
    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get the value of File Image.
     *
     * @return string
     */
    public function getFileImage(): string
    {
        return (string) $this->fileImage;
    }

    /**
     * Set the value of File Image.
     *
     * @param string $fileImage code md5
     *
     * @return self
     */
    public function setFileImage(string $fileImage): self
    {
        $this->fileImage = $fileImage;

        return $this;
    }

    /**
     * Get the value of File Fondimage.
     *
     * @return string
     */
    public function getFileFondimage(): string
    {
        return (string) $this->fileFondimage;
    }

    /**
     * Set the value of File Fondimage.
     *
     * @param string $fileFondimage code md5
     *
     * @return self
     */
    public function setFileFondimage(string $fileFondimage): self
    {
        $this->fileFondimage = $fileFondimage;

        return $this;
    }

    /**
     * Get the value of File Filigramme.
     *
     * @return string
     */
    public function getFileFiligramme(): string
    {
        return (string) $this->fileFiligramme;
    }

    /**
     * Set the value of File Filigramme.
     *
     * @param string $fileFiligramme code MD5
     *
     * @return self
     */
    public function setFileFiligramme(string $fileFiligramme): self
    {
        $this->fileFiligramme = $fileFiligramme;

        return $this;
    }

    /**
     * Get the value of File Video.
     *
     * @return string
     */
    public function getFileVideo(): string
    {
        return (string) $this->fileVideo;
    }

    /**
     * Set the value of File Video.
     *
     * @param string $fileVideo code MD5
     *
     * @return self
     */
    public function setFileVideo(string $fileVideo): self
    {
        $this->fileVideo = $fileVideo;

        return $this;
    }

    /**
     * Get the value of File Galerie.
     *
     * @return string
     */
    public function getFileGalerie(): string
    {
        return (string) $this->fileGalerie;
    }

    /**
     * Set the value of File Galerie.
     *
     * @param string $fileGalerie code md5
     *
     * @return self
     */
    public function setFileGalerie(string $fileGalerie): self
    {
        $this->fileGalerie = $fileGalerie;

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
}
