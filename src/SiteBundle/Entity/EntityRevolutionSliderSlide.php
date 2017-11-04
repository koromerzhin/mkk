<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityRevolutionSliderSlide
{
    /**
     * @var int
     *
     * @ORM\Column(name="revolutionsliderslide_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="revolutionsliderslide_titre", type="string", nullable=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="revolutionsliderslide_image", type="string", nullable=true)
     */
    protected $image;

    /**
     * @UploadableField(filename="image", path="slide/image", unique=true, alias="nom")
     */
    protected $fileImage;

    /**
     * @var int
     *
     * @ORM\Column(name="revolutionsliderslide_position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var int
     *
     * @ORM\Column(name="revolutionsliderslide_actif_public", type="integer", nullable=true)
     */
    protected $actifPublic;

    /**
     * @var array
     *
     * @ORM\Column(name="revolutionsliderslide_param", type="array", nullable=true)
     */
    protected $param;

    /**
     * @var array
     *
     * @ORM\Column(name="revolutionsliderslide_paramimage", type="array", nullable=true)
     */
    protected $paramimage;

    /**
     * @var array
     *
     * @ORM\Column(name="revolutionsliderslide_layers", type="array", nullable=true)
     */
    protected $layers;

    /**
     * @ORM\ManyToOne(targetEntity="RevolutionSlider", inversedBy="revolutionssliderslides")
     * @ORM\JoinColumn(name="revolutionsliderslide_refrevolutionslider", referencedColumnName="revolutionslider_id")
     */
    protected $refrevolutionslider;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

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
     * Set param.
     *
     * @param array $param data
     *
     * @return self
     */
    public function setParam(array $param): self
    {
        $this->param = $param;

        return $this;
    }

    /**
     * get param.
     *
     * @return array
     */
    public function getParam(): array
    {
        return $this->param;
    }

    /**
     * Set layers.
     *
     * @param array $layers data
     *
     * @return self
     */
    public function setLayers(array $layers): self
    {
        $this->layers = $layers;

        return $this;
    }

    /**
     * get layers.
     *
     * @return array
     */
    public function getLayers(): array
    {
        return $this->layers;
    }

    /**
     * Set refrevolutionslider.
     *
     * @param mixed $refrevolutionslider Entity RevolutionSlider
     *
     * @return self
     */
    public function setRefRevolutionslider($refrevolutionslider = NULL): self
    {
        $this->refrevolutionslider = $refrevolutionslider;

        return $this;
    }

    /**
     * get refrevolutionslider.
     *
     * @return self
     */
    public function getRefRevolutionslider()
    {
        return $this->refrevolutionslider;
    }

    /**
     * Set paramimage.
     *
     * @param array $paramimage paramètres
     *
     * @return self
     */
    public function setParamimage(array $paramimage): self
    {
        $this->paramimage = $paramimage;

        return $this;
    }

    /**
     * get paramimage.
     *
     * @return array
     */
    public function getParamimage(): array
    {
        return $this->paramimage;
    }

    /**
     * Set image.
     *
     * @param string $image url du fichier sur le serveur
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
    public function getImage()
    {
        return $this->image;
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
     * get position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
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
     * get actif_public.
     *
     * @return int
     */
    public function getActifpublic()
    {
        return $this->actifPublic;
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
