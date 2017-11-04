<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityPartenaire implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="partenaire_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="partenaire_nom", type="text", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="partenaire_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="partenaire_slogan", type="text", nullable=true)
     */
    protected $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="partenaire_url", type="text", nullable=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="partenaire_image", type="text", nullable=true)
     */
    protected $image;

    /**
     * @UploadableField(filename="image", path="partenaire/image", unique=true, alias="nom")
     */
    protected $fileImage;

    /**
     * @var int
     *
     * @ORM\Column(name="partenaire_actif_public", type="integer", nullable=true)
     */
    protected $actifPublic;

    /**
     * @var int
     *
     * @ORM\Column(name="partenaire_position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="partenaires")
     * @ORM\JoinColumn(name="partenaire_refcategorie", referencedColumnName="categorie_id")
     */
    protected $refcategorie;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;
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
     * @param string $nom nom
     *
     * @return self
     */
    public function setNom(string $nom): self
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
     * Set refcategorie.
     *
     * @param mixed $refcategorie Entité
     *
     * @return self
     */
    public function setRefCategorie($refcategorie = NULL): self
    {
        $this->refcategorie = $refcategorie;

        return $this;
    }

    /**
     * get refcategorie.
     *
     * @return mixed
     */
    public function getRefCategorie()
    {
        return $this->refcategorie;
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
        return (int) $this->position;
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
     * Set slogan.
     *
     * @param string $slogan slogan
     *
     * @return self
     */
    public function setSlogan(string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * get slogan.
     *
     * @return string
     */
    public function getSlogan(): string
    {
        return (string) $this->slogan;
    }

    /**
     * Retour pour selec2.
     *
     * @return mixed
     */
    public function getCategorie()
    {
        $return = !is_object($this->getRefCategorie()) ? '' : $this->getRefCategorie()->getId();

        return $return;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setCategorie($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Pour Gedmo Translate.
     *
     * @param string $locale code de la langue
     *
     * @return self
     */
    public function setTranslatableLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the value of Description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description.
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @param string $fileImage code MD5
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
