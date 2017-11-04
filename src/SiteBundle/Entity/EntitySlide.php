<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntitySlide
{
    /**
     * @var int
     *
     * @ORM\Column(name="slide_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_soustitre", type="text", nullable=true)
     */
    protected $soustitre;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_url", type="text", nullable=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_contenu", type="text", nullable=true)
     */
    protected $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_vignette", type="text", nullable=true)
     */
    protected $vignette;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_type", type="text", nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_image", type="text", nullable=true)
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_imagemobile", type="text", nullable=true)
     */
    protected $imagemobile;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_opacity", type="text", nullable=true)
     */
    protected $opacity;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_videobackground", type="text", nullable=true)
     */
    protected $videobackground;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_videoiframe", type="text", nullable=true)
     */
    protected $videoiframe;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_video", type="text", nullable=true)
     */
    protected $video;

    /**
     * @var int
     *
     * @ORM\Column(name="slide_position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_actif_public", type="text", nullable=true)
     */
    protected $actifPublic;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="slide_filtre", type="boolean", nullable=true)
     */
    protected $filtre;

    /**
     * get the value of Id.
     *
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * get the value of Titre.
     *
     * @return string
     */
    public function getTitre(): string
    {
        return (string) $this->titre;
    }

    /**
     * Set the value of Titre.
     *
     * @param string $titre string
     *
     * @return self
     */
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * get the value of Soustitre.
     *
     * @return string
     */
    public function getSoustitre(): string
    {
        return (string) $this->soustitre;
    }

    /**
     * Set the value of Soustitre.
     *
     * @param string $soustitre string
     *
     * @return self
     */
    public function setSoustitre(string $soustitre): self
    {
        $this->soustitre = $soustitre;

        return $this;
    }

    /**
     * get the value of Url.string.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return (string) $this->url;
    }

    /**
     * Set the value of Url.
     *
     * @param string $url string
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * get the value of Contenu.
     *
     * @return string
     */
    public function getContenu(): string
    {
        return (string) $this->contenu;
    }

    /**
     * Set the value of Contenu.
     *
     * @param string $contenu string
     *
     * @return self
     */
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * get the value of Vignette.
     *
     * @return string
     */
    public function getVignette()
    {
        $file = $this->vignette;

        return $file;
    }

    /**
     * Set the value of Vignette.
     *
     * @param string $vignette string
     *
     * @return self
     */
    public function setVignette(string $vignette): self
    {
        $this->vignette = $vignette;

        return $this;
    }

    /**
     * get the value of Type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type.
     *
     * @param string $type string
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * get the value of Image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of Image.
     *
     * @param string $image string
     *
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * get the value of Imagemobile.
     *
     * @return string
     */
    public function getImagemobile()
    {
        return $this->imagemobile;
    }

    /**
     * Set the value of Imagemobile.
     *
     * @param string $imagemobile image
     *
     * @return self
     */
    public function setImagemobile(string $imagemobile): self
    {
        $this->imagemobile = $imagemobile;

        return $this;
    }

    /**
     * get the value of Opacity.
     *
     * @return string
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * Set the value of Opacity.
     *
     * @param string $opacity string
     *
     * @return self
     */
    public function setOpacity(string $opacity): self
    {
        $this->opacity = $opacity;

        return $this;
    }

    /**
     * get the value of Videobackground.
     *
     * @return string
     */
    public function getVideobackground()
    {
        return $this->videobackground;
    }

    /**
     * Set the value of Videobackground.
     *
     * @param string $videobackground string
     *
     * @return self
     */
    public function setVideobackground(string $videobackground): self
    {
        $this->videobackground = $videobackground;

        return $this;
    }

    /**
     * get the value of Videoiframe.
     *
     * @return string
     */
    public function getVideoiframe()
    {
        return $this->videoiframe;
    }

    /**
     * Set the value of Videoiframe.
     *
     * @param string $videoiframe string
     *
     * @return self
     */
    public function setVideoiframe(string $videoiframe): self
    {
        $this->videoiframe = $videoiframe;

        return $this;
    }

    /**
     * get the value of Video.
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set the value of Video.
     *
     * @param string $video lien de la video
     *
     * @return self
     */
    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * get the value of Position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Set the value of Position.
     *
     * @param int $position chiffre
     *
     * @return self
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * get the value of Actif Public.
     *
     * @return bool
     */
    public function isActifPublic(): bool
    {
        return $this->actifPublic;
    }

    /**
     * Set the value of Actif Public.
     *
     * @param bool $actifPublic boolean
     *
     * @return self
     */
    public function setActifPublic(bool $actifPublic): self
    {
        $this->actifPublic = $actifPublic;

        return $this;
    }

    /**
     * get the value of Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return (string) $this->description;
    }

    /**
     * Set the value of Description.
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * get the value of Filtre.
     *
     * @return string
     */
    public function getFiltre(): string
    {
        return (string) $this->filtre;
    }

    /**
     * Set the value of Filtre.
     *
     * @param string $filtre text
     *
     * @return self
     */
    public function setFiltre($filtre): self
    {
        $this->filtre = $filtre;

        return $this;
    }
}
