<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityBookmark implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="bookmark_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Slug(updatable=false, fields={"titre"})
     * @ORM\Column(name="bookmark_alias", type="string")
     */
    protected $alias;

    /**
     * @var string
     * @ORM\Column(name="bookmark_titre", type="string")
     */
    protected $titre;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bookmark_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="bookmark_url", type="text")
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="bookmark_image", type="string", nullable=true)
     */
    protected $image;

    /**
     * @UploadableField(filename="image", path="bookmark/image", unique=true, alias="titre")
     */
    protected $fileImage;

    /**
     * @var int
     *
     * @ORM\Column(name="bookmark_date", type="integer", nullable=true)
     */
    protected $date;

    /**
     * @ORM\ManyToMany(targetEntity="Tag",  mappedBy="bookmarks")
     */
    protected $tags;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bookmark_meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bookmark_meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * Add tags.
     *
     * @param mixed $tags entity
     *
     * @return self
     */
    public function addTag($tags): self
    {
        $this->tags->add($tags);

        return $this;
    }

    /**
     * Remove tags.
     *
     * @param mixed $tags Entity
     *
     * @return self
     */
    public function removeTag($tags): self
    {
        $this->tags->removeElement($tags);

        return $this;
    }

    /**
     * get tags.
     *
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the value of Tags.
     *
     * @param mixed $tags tags
     *
     * @return self
     */
    public function setTags($tags): self
    {
        $this->tags = $tags;

        return $this;
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
     * get alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return (string) $this->alias;
    }

    /**
     * Set alias.
     *
     * @param mixed $alias alias
     *
     * @return self
     */
    public function setAlias($alias): self
    {
        $this->alias = $alias;

        return $this;
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
     * @param mixed $description description
     *
     * @return self
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * get the value of Url.
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
     * get the value of Image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return (string) $this->image;
    }

    /**
     * Set the value of Image.
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
     * get the value of Date.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Date.
     *
     * @param int $date date
     *
     * @return self
     */
    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
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
}
