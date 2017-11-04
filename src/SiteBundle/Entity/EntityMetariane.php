<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityMetariane
{
    /**
     * @var int
     *
     * @ORM\Column(name="metariane_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="metariane_route", unique=true, type="string", length=255)
     */
    protected $route;

    /**
     * @var string
     * @ORM\Column(name="metariane_pattern", type="text", nullable=true)
     */
    protected $pattern;

    /**
     * @var string
     * @ORM\Column(name="metariane_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var string
     * @ORM\Column(name="metariane_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(name="metariane_keywords", type="text", nullable=true)
     */
    protected $keywords;

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getRoute();

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
     * Set route.
     *
     * @param string $route route
     *
     * @return self
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * get route.
     *
     * @return string
     */
    public function getRoute(): string
    {
        return (string) $this->route;
    }

    /**
     * Set titre.
     *
     * @param mixed $pattern pattern
     *
     * @return self
     */
    public function setPattern($pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * get pattern.
     *
     * @return string
     */
    public function getPattern(): string
    {
        return (string) $this->pattern;
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
     * Set description.
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
     * get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return (string) $this->description;
    }

    /**
     * Set keywords.
     *
     * @param string $keywords keywords
     *
     * @return self
     */
    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * get keywords.
     *
     * @return string
     */
    public function getKeywords(): string
    {
        return (string) $this->keywords;
    }
}
