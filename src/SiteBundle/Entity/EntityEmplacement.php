<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class EntityEmplacement
{
    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="refemplacement", cascade={"remove", "persist"})
     */
    protected $adresses;

    /**
     * @var bool
     *
     * @ORM\Column(name="emplacement_placeillimite", type="boolean", nullable=true)
     */
    protected $placeillimite;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="emplacements")
     * @ORM\JoinColumn(name="emplacement_refetablissement", referencedColumnName="etablissement_id")
     */
    protected $refetablissement;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="emplacements")
     * @ORM\JoinColumn(name="emplacement_refevenement", referencedColumnName="evenement_id")
     */
    protected $refevenement;

    /**
     * @ORM\OneToMany(targetEntity="Date", mappedBy="refemplacement", cascade={"remove", "persist"})
     * @ORM\OrderBy({"debut": "ASC"})
     */
    protected $dates;

    /**
     * @var string
     *
     * @ORM\Column(name="emplacement_totalnbdate", type="integer", options={"default": 0})
     */
    protected $totalnbdate;

    /**
     * @var string
     *
     * @ORM\Column(name="emplacement_totalnbplace", type="integer", options={"default": 0})
     */
    protected $totalnbplace;

    /**
     * @var int
     *
     * @ORM\Column(name="emplacement_mindate", type="integer", options={"default": 0})
     */
    protected $mindate;

    /**
     * @var int
     *
     * @ORM\Column(name="emplacement_maxdate", type="integer", options={"default": 0})
     */
    protected $maxdate;

    /**
     * @var int
     *
     * @ORM\Column(name="emplacement_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->totalnbdate  = 0;
        $this->totalnbplace = 0;
        $this->mindate      = 0;
        $this->maxdate      = 0;
        $this->adresses     = new ArrayCollection();
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $adresses = $this->getAdresses();
        if (0 !== count($adresses)) {
            foreach ($adresses as $adresse) {
                $texte = $adresse->getInfo() . ' - ' . $adresse->getCp() . ' ' . $adresse->getVille();
                break;
            }
        } else {
            $texte = $this->getRefEtablissement()->getNom();
        }

        $return = (string) $texte;

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
     * Add adresses.
     *
     * @param mixed $adresses entity
     *
     * @return self
     */
    public function addAdress($adresses): self
    {
        $adresses->setRefEmplacement($this);
        $this->adresses->add($adresses);

        return $this;
    }

    /**
     * Remove adresses.
     *
     * @param mixed $adresses Entity
     *
     * @return self
     */
    public function removeAdress($adresses): self
    {
        $this->adresses->removeElement($adresses);

        return $this;
    }

    /**
     * get adresses.
     *
     * @return mixed
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set refletablissement.
     *
     * @param mixed $refetablissement etablissement
     *
     * @return self
     */
    public function setRefEtablissement($refetablissement = NULL): self
    {
        $this->refetablissement = $refetablissement;

        return $this;
    }

    /**
     * get refetablissement.
     *
     * @return mixed
     */
    public function getRefEtablissement()
    {
        return $this->refetablissement;
    }

    /**
     * Set refevenement.
     *
     * @param mixed $refevenement evenement
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

    /**
     * Add dates.
     *
     * @param mixed $dates entity
     *
     * @return self
     */
    public function addDate($dates): self
    {
        $dates->setRefEmplacement($this);
        $this->dates->add($dates);

        return $this;
    }

    /**
     * Remove dates.
     *
     * @param mixed $dates Entity
     *
     * @return self
     */
    public function removeDate($dates): self
    {
        $this->dates->removeElement($dates);

        return $this;
    }

    /**
     * get dates.
     *
     * @return mixed
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Récupére les dates avec place.
     *
     * @return array
     */
    public function getDatesAvecPlace(): array
    {
        $places = [];
        $dates  = $this->getDates();
        foreach ($dates as $date) {
            if ($date->getReservationsRestant() > 0) {
                $places[] = $date;
            }
        }

        return $places;
    }

    /**
     * Set the value of Adresses.
     *
     * @param array $adresses adresses
     *
     * @return self
     */
    public function setAdresses($adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }

    /**
     * Set the value of Dates.
     *
     * @param array $dates dates
     *
     * @return self
     */
    public function setDates($dates): self
    {
        $this->dates = $dates;

        return $this;
    }

    /**
     * get the value of Totalnbdate.
     *
     * @return string
     */
    public function getTotalnbdate(): int
    {
        return $this->totalnbdate;
    }

    /**
     * Set the value of Totalnbdate.
     *
     * @param int $totalnbdate totalnbdate
     *
     * @return self
     */
    public function setTotalnbdate(int $totalnbdate): self
    {
        $this->totalnbdate = $totalnbdate;

        return $this;
    }

    /**
     * get the value of Mindate.
     *
     * @return int
     */
    public function getMindate(): int
    {
        return $this->mindate;
    }

    /**
     * Set the value of Mindate.
     *
     * @param int $mindate mindate
     *
     * @return self
     */
    public function setMindate(int $mindate): self
    {
        $this->mindate = $mindate;

        return $this;
    }

    /**
     * get the value of Maxdate.
     *
     * @return int
     */
    public function getMaxdate(): int
    {
        return $this->maxdate;
    }

    /**
     * Set the value of Maxdate.
     *
     * @param int $maxdate maxdate
     *
     * @return self
     */
    public function setMaxdate(int $maxdate): self
    {
        $this->maxdate = $maxdate;

        return $this;
    }

    /**
     * get the value of Totalnbplace.
     *
     * @return int
     */
    public function getTotalnbplace(): int
    {
        return $this->totalnbplace;
    }

    /**
     * Set the value of Totalnbplace.
     *
     * @param int $totalnbplace totalnbplace
     *
     * @return self
     */
    public function setTotalnbplace(int $totalnbplace): self
    {
        $this->totalnbplace = $totalnbplace;

        return $this;
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
