<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class EntityTemplates implements Translatable
{
    /**
     * @var int
     * @ORM\Column(name="templates_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="templates_type", type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="templates_nom", type="string", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="templates_content", type="text", nullable=true, nullable=true)
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="templates_code", type="string", length=255)
     */
    protected $code; /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;

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
     * Set type.
     *
     * @param string $type type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * get type.
     *
     * @return string
     */
    public function getType(): string
    {
        return (string) $this->type;
    }

    /**
     * Set content.
     *
     * @param string $content content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * get content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return (string) $this->content;
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
     * Set code.
     *
     * @param string $code code
     *
     * @return self
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
}
