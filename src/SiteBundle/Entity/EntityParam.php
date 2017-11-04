<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityParam
{
    /**
     * @var int
     *
     * @ORM\Column(name="param_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="param_code", unique=true, type="string", length=255)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="param_valeur", type="text", nullable=true)
     */
    protected $valeur;

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
     * Set valeur.
     *
     * @param string $valeur valeur
     *
     * @return self
     */
    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * get valeur.
     *
     * @return string
     */
    public function getValeur(): string
    {
        return (string) $this->valeur;
    }
}
