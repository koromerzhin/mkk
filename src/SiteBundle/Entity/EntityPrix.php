<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityPrix
{
    /**
     * @var int
     *
     * @ORM\Column(name="prix_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_chiffre", type="text", nullable=true)
     */
    protected $chiffre;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_type", type="text", nullable=true)
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="prixs")
     * @ORM\JoinColumn(name="prix_refevenement", referencedColumnName="evenement_id", nullable=true)
     */
    protected $refevenement;

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
     * Set chiffre.
     *
     * @param string $chiffre chiffre
     *
     * @return self
     */
    public function setChiffre(string $chiffre): self
    {
        $this->chiffre = $chiffre;

        return $this;
    }

    /**
     * get chiffre.
     *
     * @return string
     */
    public function getChiffre(): string
    {
        return (string) $this->chiffre;
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
     * Set refevenement.
     *
     * @param mixed $refevenement Entité
     *
     * @return self
     */
    public function setRefEvenement($refevenement = NULL): self
    {
        $this->refevenement = $refevenement;

        return $this;
    }

    /**
     * get refevenement.
     *
     * @return mixed
     */
    public function getRefEvenement()
    {
        return $this->refevenement;
    }
}
