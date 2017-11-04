<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityEmail
{
    /**
     * @var int
     *
     * @ORM\Column(name="email_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email_adresse", type="text")
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="email_type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="emails")
     * @ORM\JoinColumn(
     *     name="email_refevenement",
     *     referencedColumnName="evenement_id",
     *     nullable=true,
     * onDelete="CASCADE")
     */
    protected $refevenement;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="emails")
     * @ORM\JoinColumn(name="email_refuser", referencedColumnName="user_id", nullable=true, onDelete="CASCADE")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="emails")
     * @ORM\JoinColumn(
     *     name="email_refetablissement",
     *     referencedColumnName="etablissement_id",
     *     nullable=true,
     * onDelete="CASCADE")
     */
    protected $refetablissement;

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
     * Set adresse.
     *
     * @param string $adresse adresse
     *
     * @return self
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * get adresse.
     *
     * @return string
     */
    public function getAdresse(): string
    {
        return (string) $this->adresse;
    }

    /**
     * Set type.
     *
     * @param mixed $type type
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
