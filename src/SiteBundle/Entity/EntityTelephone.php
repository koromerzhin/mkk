<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityTelephone
{
    /**
     * @var int
     *
     * @ORM\Column(name="telephone_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_chiffre", type="text")
     */
    protected $chiffre;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_utilisation", type="string", nullable=true)
     */
    protected $utilisation;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_pays", type="string", nullable=true)
     */
    protected $pays;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="telephones")
     * @ORM\JoinColumn(
     *     name="telephone_refevenement",
     *     referencedColumnName="evenement_id",
     *     nullable=true,
     *     onDelete="CASCADE"
     * )
     */
    protected $refevenement;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="telephones")
     * @ORM\JoinColumn(name="telephone_refuser", referencedColumnName="user_id", nullable=true, onDelete="CASCADE")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="telephones")
     * @ORM\JoinColumn(
     *     name="telephone_refetablissement",
     *     referencedColumnName="etablissement_id",
     *     nullable=true,
     *     onDelete="CASCADE"
     * )
     */
    protected $refetablissement;

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getChiffre();

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
    public function setType($type): self
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
     * Set chiffre.
     *
     * @param string $chiffre chiffre
     *
     * @return self
     */
    public function setChiffre(string $chiffre)
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
        $chiffre = str_replace(' ', '', $this->chiffre);

        return (string) $chiffre;
    }

    /**
     * Set pays.
     *
     * @param string $pays pays
     *
     * @return self
     */
    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * get pays.
     *
     * @return string
     */
    public function getPays(): string
    {
        return (string) $this->pays;
    }

    /**
     * Set utilisation.
     *
     * @param string $utilisation utilisation
     *
     * @return self
     */
    public function setUtilisation(string $utilisation): self
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    /**
     * get utilisation.
     *
     * @return string
     */
    public function getUtilisation(): string
    {
        return (string) $this->utilisation;
    }

    /**
     * Set refuser.
     *
     * @param mixed $refuser user
     *
     * @return self
     */
    public function setRefUser($refuser = NULL): self
    {
        $this->refuser = $refuser;

        return $this;
    }

    /**
     * get refuser.
     *
     * @return mixed
     */
    public function getRefUser()
    {
        return $this->refuser;
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
}
