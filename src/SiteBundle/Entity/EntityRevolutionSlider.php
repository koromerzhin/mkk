<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class EntityRevolutionSlider
{
    /**
     * @var int
     *
     * @ORM\Column(name="revolutionslider_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="revolutionslider_titre", type="string", nullable=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="revolutionslider_code", type="string", nullable=true)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="revolutionslider_langue", type="text", nullable=true)
     */
    protected $langue;

    /**
     * @var array
     *
     * @ORM\Column(name="revolutionslider_param", type="array", nullable=true)
     */
    protected $param;

    /**
     * @ORM\OneToMany(
     *     targetEntity="RevolutionSliderSlide",
     *     mappedBy="refrevolutionslider",
     *     cascade={"remove", "persist"}
     * )
     * @ORM\OrderBy({"position": "ASC"})
     */
    protected $slides;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->slides = new ArrayCollection();
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
    public function getCode(): string
    {
        return (string) $this->code;
    }

    /**
     * Set langue.
     *
     * @param string $langue langue
     *
     * @return self
     */
    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * get langue.
     *
     * @return string
     */
    public function getLangue(): string
    {
        return (string) $this->langue;
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
     * @return string
     */
    public function getParam(): array
    {
        return $this->param;
    }

    /**
     * Add slides.
     *
     * @param mixed $slides entity
     *
     * @return self
     */
    public function addRevolutionSliderSlide($slides): self
    {
        $slides->setRefRevolutionSlider($this);
        $this->slides->add($slides);

        return $this;
    }

    /**
     * Remove slides.
     *
     * @param mixed $slides Entity
     *
     * @return self
     */
    public function removeRevolutionSliderSlide($slides): self
    {
        $this->slides->removeElement($slides);

        return $this;
    }

    /**
     * get slides.
     *
     * @return mixed
     */
    public function getRevolutionSliderSlides()
    {
        return $this->slides;
    }
}
