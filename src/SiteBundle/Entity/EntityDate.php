<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

class EntityDate
{
    /**
     * @var int
     *
     * @ORM\Column(name="date_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="date_debut", type="integer")
     */
    protected $debut;

    /**
     * @var int
     *
     * @ORM\Column(name="date_place", type="integer", nullable=true)
     */
    protected $place;

    /**
     * @var bool
     *
     * @ORM\Column(name="date_placeillimite", type="boolean", nullable=true)
     */
    protected $placeillimite;

    /**
     * @var int
     *
     * @ORM\Column(name="date_fin", type="integer")
     */
    protected $fin;

    /**
     * @JMS\Exclude
     * @ORM\ManyToOne(targetEntity="Emplacement", inversedBy="dates")
     * @ORM\JoinColumn(name="date_refemplacement", referencedColumnName="emplacement_id", nullable=false)
     */
    protected $refemplacement;

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
     * Set debut.
     *
     * @param int $debut debut
     *
     * @return self
     */
    public function setDebut($debut): self
    {
        $this->debut = $debut;
        if (0 !== substr_count($debut, ' ')) {
            list($date, $horaire)      = explode(' ', $debut);
            list($jour, $mois, $annee) = explode('/', $date);
            list($heure, $minute)      = explode(':', $horaire);
            $this->debut               = mktime($heure, $minute, 0, $mois, $jour, $annee);
        }

        return $this;
    }

    /**
     * get debut.
     *
     * @return int
     */
    public function getDebut(): int
    {
        return $this->debut;
    }

    /**
     * Set fin.
     *
     * @param int $fin fin
     *
     * @return self
     */
    public function setFin($fin): self
    {
        $this->fin = $fin;
        if (0 !== substr_count($fin, ' ')) {
            list($date, $horaire)      = explode(' ', $fin);
            list($jour, $mois, $annee) = explode('/', $date);
            list($heure, $minute)      = explode(':', $horaire);
            $this->fin                 = mktime($heure, $minute, 0, $mois, $jour, $annee);
        }

        return $this;
    }

    /**
     * get fin.
     *
     * @return int
     */
    public function getFin(): int
    {
        return $this->fin;
    }

    /**
     * Set refemplacement.
     *
     * @param mixed $refemplacement emplacement
     *
     * @return self
     */
    public function setRefEmplacement($refemplacement): self
    {
        $this->refemplacement = $refemplacement;

        return $this;
    }

    /**
     * get refemplacement.
     *
     * @return mixed
     */
    public function getRefEmplacement()
    {
        return $this->refemplacement;
    }

    /**
     * Set place.
     *
     * @param int $place place
     *
     * @return self
     */
    public function setPlace(int $place): self
    {
        $this->place = (int) $place;

        return $this;
    }

    /**
     * get fin.
     *
     * @return int
     */
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * get the value of Placeillimite.
     *
     * @return bool
     */
    public function isPlaceillimite(): bool
    {
        return $this->placeillimite;
    }

    /**
     * Set the value of Placeillimite.
     *
     * @param bool $placeillimite placeillimite
     *
     * @return self
     */
    public function setPlaceillimite(bool $placeillimite): self
    {
        $this->placeillimite = $placeillimite;

        return $this;
    }
}
