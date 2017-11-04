<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class EntityEdito implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="edito_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="edito_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="edito_datedebut", type="datetime", nullable=true)
     */
    protected $datedebut;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="edito_datefin", type="datetime", nullable=true)
     */
    protected $datefin;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="edito_contenu", type="text", nullable=true)
     */
    protected $contenu;

    /**
     * @var bool
     *
     * @ORM\Column(name="edito_publier", type="boolean", nullable=true)
     */
    protected $publier;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="editos")
     * @ORM\JoinColumn(name="edito_refuser", referencedColumnName="user_id")
     */
    protected $refuser; /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;

    /**
     * Init.
     */
    public function __construct()
    {
        $this->datedebut = NULL;
        $this->datefin   = NULL;
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getTitre();

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
     * Set datedebut.
     *
     * @param DateTime $datedebut datedebut
     *
     * @return self
     */
    public function setDatedebut(DateTime $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * get datedebut.
     *
     * @return mixed
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin.
     *
     * @param DateTime $datefin datefin
     *
     * @return self
     */
    public function setDatefin(DateTime $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * get datefin.
     *
     * @return mixed
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set contenu.
     *
     * @param string $contenu contenu
     *
     * @return self
     */
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * get contenu.
     *
     * @return string
     */
    public function getContenu(): string
    {
        return (string) $this->contenu;
    }

    /**
     * Set publier.
     *
     * @param bool $publier publier
     *
     * @return self
     */
    public function setPublier($publier): self
    {
        $this->publier = $publier;

        return $this;
    }

    /**
     * get publier.
     *
     * @return bool
     */
    public function isPublier(): bool
    {
        return $this->publier;
    }

    /**
     * Set refuser.
     *
     * @param mixed $refuser uset
     *
     * @return self
     */
    public function setRefUser($refuser): self
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

    /**
     * Retour pour selec2.
     *
     * @return mixed
     */
    public function getUser()
    {
        $return = !is_object($this->getRefUser()) ? '' : $this->getRefUser()->getId();

        return $return;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setUser($valNull): self
    {
        unset($valNull);

        return $this;
    }
}
