<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityHoraire
{
    /**
     * @var int
     *
     * @ORM\Column(name="horaire_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="horaire_jour", type="integer")
     */
    protected $jour;

    /**
     * @var float
     *
     * @ORM\Column(name="horaire_dm", type="text", nullable=true)
     */
    protected $dm;

    /**
     * @var float
     *
     * @ORM\Column(name="horaire_fm", type="text", nullable=true)
     */
    protected $fm;

    /**
     * @var float
     *
     * @ORM\Column(name="horaire_da", type="text", nullable=true)
     */
    protected $da;

    /**
     * @var float
     *
     * @ORM\Column(name="horaire_fa", type="text", nullable=true)
     */
    protected $fa;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="horaires")
     * @ORM\JoinColumn(
     *     name="horaire_refetablissement",
     *     nullable=true,
     *     referencedColumnName="etablissement_id",
     * onDelete="CASCADE")
     */
    protected $refetablissement;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->dm = '00:00';
        $this->fm = '00:00';
        $this->da = '00:00';
        $this->fa = '00:00';
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
     * Set jour.
     *
     * @param int $jour jour de la semaine
     *
     * @return self
     */
    public function setJour(int $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * get jour.
     *
     * @return int
     */
    public function getJour(): int
    {
        return $this->jour;
    }

    /**
     * Set dm.
     *
     * @param mixed $dm Heure début de matinée
     *
     * @return self
     */
    public function setDm($dm): self
    {
        $this->dm = $dm;

        return $this;
    }

    /**
     * get dm.
     *
     * @return string
     */
    public function getDm(): string
    {
        return (string) $this->dm;
    }

    /**
     * Set fm.
     *
     * @param mixed $fm Heure fin de matinée
     *
     * @return self
     */
    public function setFm($fm): self
    {
        $this->fm = $fm;

        return $this;
    }

    /**
     * get fm.
     *
     * @return string
     */
    public function getFm(): string
    {
        return (string) $this->fm;
    }

    /**
     * Set da.
     *
     * @param mixed $da Heure début d'après midi
     *
     * @return self
     */
    public function setDa($da): self
    {
        $this->da = $da;

        return $this;
    }

    /**
     * get da.
     *
     * @return string
     */
    public function getDa(): string
    {
        return (string) $this->da;
    }

    /**
     * Set fa.
     *
     * @param mixed $fa Heure fin d'après midi
     *
     * @return self
     */
    public function setFa($fa): self
    {
        $this->fa = $fa;

        return $this;
    }

    /**
     * get fa.
     *
     * @return float
     */
    public function getFa(): string
    {
        return (string) $this->fa;
    }

    /**
     * Set refetablissement.
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
}
