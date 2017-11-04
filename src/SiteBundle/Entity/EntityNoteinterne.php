<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class EntityNoteinterne implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="noteinterne_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="noteinterne_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="noteinterne_datemodification", type="integer", nullable=true)
     */
    protected $datemodification;

    /**
     * @var int
     *
     * @ORM\Column(name="noteinterne_datedebut", type="integer", nullable=true)
     */
    protected $datedebut;

    /**
     * @var int
     *
     * @ORM\Column(name="noteinterne_datefin", type="integer", nullable=true)
     */
    protected $datefin;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="noteinterne_contenu", type="text", nullable=true)
     */
    protected $contenu;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="noteinterne_lien", type="text", nullable=true)
     */
    protected $lien;

    /**
     * @var bool
     *
     * @ORM\Column(name="noteinterne_publier", type="boolean", nullable=true)
     */
    protected $publier;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="noteinternes")
     * @ORM\JoinColumn(name="noteinterne_refuser", referencedColumnName="user_id")
     */
    protected $refuser;

    /**
     * @ORM\OneToMany(targetEntity="NoteinterneLecture", mappedBy="refnoteinterne", cascade={"remove", "persist"})
     */
    protected $noteinternelectures;
    /**
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
        $this->noteinternelectures = new ArrayCollection();
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
     * @param DateTime $datedebut date
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
     * Set datemodification.
     *
     * @param DateTime $datemodification date
     *
     * @return self
     */
    public function setDatemodification(DateTime $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    /**
     * get datemodification.
     *
     * @return mixed
     */
    public function getDatemodification()
    {
        return $this->datemodification;
    }

    /**
     * Set datefin.
     *
     * @param DateTime $datefin date
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
     * Set lien.
     *
     * @param string $lien lien
     *
     * @return self
     */
    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * get lien.
     *
     * @return string
     */
    public function getLien(): string
    {
        return (string) $this->lien;
    }

    /**
     * Set publier.
     *
     * @param bool $publier publier
     *
     * @return self
     */
    public function setPublier(bool $publier): self
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
        return (bool) $this->publier;
    }

    /**
     * Set refuser.
     *
     * @param mixed $refuser Entité
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
     * Add noteinternelectures.
     *
     * @param mixed $noteinternelectures entity
     *
     * @return self
     */
    public function addNoteinterneLecture($noteinternelectures): self
    {
        $noteinternelectures->setRefNoteInterne($this);
        $this->noteinternelectures->add($noteinternelectures);

        return $this;
    }

    /**
     * Remove lectures.
     *
     * @param mixed $noteinternelectures Entity
     *
     * @return self
     */
    public function removeNoteinterneLecture($noteinternelectures): self
    {
        $this->noteinternelectures->removeElement($noteinternelectures);

        return $this;
    }

    /**
     * get noteinternelectures.
     *
     * @return mixed
     */
    public function getNoteinterneLectures()
    {
        return $this->noteinternelectures;
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
}
