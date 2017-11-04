<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityEvenement
{
    /**
     * @JMS\Exclude
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="evenements")
     * @ORM\JoinColumn(name="evenement_refcategorie", referencedColumnName="categorie_id")
     */
    protected $refcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="evenement_totalnbdate", type="integer", options={"default": 0})
     */
    protected $totalnbdate;

    /**
     * @var string
     *
     * @ORM\Column(name="evenement_totalnbplace", type="integer", options={"default": 0})
     */
    protected $totalnbplace;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_placeillimite", type="boolean", nullable=true)
     */
    protected $placeillimite;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Prix", mappedBy="refevenement", cascade={"remove", "persist"})
     */
    protected $prixs;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Email", mappedBy="refevenement", cascade={"remove", "persist"})
     */
    protected $emails;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Telephone", mappedBy="refevenement", cascade={"remove", "persist"})
     */
    protected $telephones;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Lien", mappedBy="refevenement", cascade={"remove", "persist"})
     */
    protected $liens;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Emplacement",  mappedBy="refevenement", cascade={"remove", "persist"})
     */
    protected $emplacements;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="evenements")
     * @ORM\JoinColumn(name="evenement_refuser", referencedColumnName="user_id", nullable=true)
     */
    protected $refuser;

    /**
     * @var int
     *
     * @ORM\Column(name="evenement_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="evenement_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_type", type="boolean", options={"default": 0}, nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="evenement_copyright", type="text", nullable=true)
     */
    protected $copyright;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_publier", type="boolean", nullable=true)
     */
    protected $publier;

    /**
     * @var string
     * @Gedmo\Translatable
     * @Gedmo\Slug(updatable=false, fields={"titre"})
     * @ORM\Column(name="evenement_alias", type="text", nullable=true)
     */
    protected $alias;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="evenement_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_externe", type="boolean", nullable=true)
     */
    protected $externe;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_validation", type="boolean", nullable=true)
     */
    protected $validation;

    /**
     * @var bool
     *
     * @ORM\Column(name="evenement_correction", type="boolean", nullable=true)
     */
    protected $correction;

    /**
     * @var string
     *
     * @ORM\Column(name="evenement_vignette", type="string", nullable=true)
     */
    protected $vignette;

    /**
     * @UploadableField(filename="vignette", path="bookmark/vignette", unique=true, alias="titre")
     */
    protected $fileVignette;

    /**
     * @var array
     *
     * @ORM\Column(name="evenement_galerie", type="array", nullable=true)
     */
    protected $galerie;

    /**
     * @UploadableField(filename="galerie", path="bookmark/galerie", unique=false, alias="titre")
     */
    protected $fileGalerie;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="evenement_totalnbemplacement", type="integer", options={"default": 0})
     */
    protected $totalnbemplacement;

    /**
     * @var int
     *
     * @ORM\Column(name="evenement_mindate", type="integer", options={"default": 0})
     */
    protected $mindate;

    /**
     * @var int
     *
     * @ORM\Column(name="evenement_maxdate", type="integer", options={"default": 0})
     */
    protected $maxdate;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->totalnbdate        = 0;
        $this->totalnbplace       = 0;
        $this->totalnbemplacement = 0;
        $this->mindate            = 0;
        $this->maxdate            = 0;
        $this->galerie            = [];
        $this->prixs              = new ArrayCollection();
        $this->emails             = new ArrayCollection();
        $this->emplacements       = new ArrayCollection();
        $this->telephones         = new ArrayCollection();
        $this->liens              = new ArrayCollection();
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
     * Set description.
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return (string) $this->description;
    }

    /**
     * Set externe.
     *
     * @param bool $externe etat externe
     *
     * @return self
     */
    public function setExterne($externe): self
    {
        $this->externe = $externe;

        return $this;
    }

    /**
     * get externe.
     *
     * @return bool
     */
    public function isExterne(): bool
    {
        return $this->externe;
    }

    /**
     * Set validation.
     *
     * @param bool $validation etat validation
     *
     * @return self
     */
    public function setValidation($validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * get validation.
     *
     * @return bool
     */
    public function isValidation(): bool
    {
        return $this->validation;
    }

    /**
     * Set correction.
     *
     * @param bool $correction etat correction
     *
     * @return self
     */
    public function setCorrection($correction): self
    {
        $this->correction = $correction;

        return $this;
    }

    /**
     * get correction.
     *
     * @return bool
     */
    public function isCorrection(): bool
    {
        return $this->correction;
    }

    /**
     * Set refcategorie.
     *
     * @param mixed $refcategorie categorie
     *
     * @return self
     */
    public function setRefCategorie($refcategorie = NULL): self
    {
        $this->refcategorie = $refcategorie;

        return $this;
    }

    /**
     * get refcategorie.
     *
     * @return mixed
     */
    public function getRefCategorie()
    {
        return $this->refcategorie;
    }

    /**
     * Set alias.
     *
     * @param mixed $alias alias
     *
     * @return self
     */
    public function setAlias($alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * get alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return (string) $this->alias;
    }

    /**
     * Add emails.
     *
     * @param mixed $emails entity
     *
     * @return self
     */
    public function addEmail($emails): self
    {
        $emails->setRefEvenement($this);
        $this->emails->add($emails);

        return $this;
    }

    /**
     * Remove emails.
     *
     * @param mixed $emails Entity
     *
     * @return self
     */
    public function removeEmail($emails): self
    {
        $this->emails->removeElement($emails);

        return $this;
    }

    /**
     * get emails.
     *
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add liens.
     *
     * @param mixed $liens entity
     *
     * @return self
     */
    public function addLien($liens): self
    {
        $liens->setRefEvenement($this);
        $this->liens->add($liens);

        return $this;
    }

    /**
     * Remove liens.
     *
     * @param mixed $liens Entity
     *
     * @return self
     */
    public function removeLien($liens): self
    {
        $this->liens->removeElement($liens);

        return $this;
    }

    /**
     * get liens.
     *
     * @return mixed
     */
    public function getLiens()
    {
        return $this->liens;
    }

    /**
     * Set galerie.
     *
     * @param array $galerie liste des images
     *
     * @return self
     */
    public function setGalerie(array $galerie): self
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * get galerie.
     *
     * @return array
     */
    public function getGalerie(): array
    {
        return $this->galerie;
    }

    /**
     * Add telephones.
     *
     * @param mixed $telephones entity
     *
     * @return self
     */
    public function addTelephone($telephones): self
    {
        $telephones->setRefEvenement($this);
        $this->telephones->add($telephones);

        return $this;
    }

    /**
     * Remove telephones.
     *
     * @param mixed $telephones Entity
     *
     * @return self
     */
    public function removeTelephone($telephones): self
    {
        $this->telephones->removeElement($telephones);

        return $this;
    }

    /**
     * get telephones.
     *
     * @return mixed
     */
    public function getTelephones()
    {
        return $this->telephones;
    }

    /**
     * Set refuser.
     *
     * @param mixed $refuser User
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
     * get prixs.
     *
     * @return mixed
     */
    public function getPrixs()
    {
        return $this->prixs;
    }

    /**
     * Set vignette.
     *
     * @param string $vignette vignette
     *
     * @return self
     */
    public function setVignette(string $vignette): self
    {
        $this->vignette = $vignette;

        return $this;
    }

    /**
     * get vignette.
     *
     * @return string
     */
    public function getVignette(): string
    {
        return (string) $this->vignette;
    }

    /**
     * Add prixs.
     *
     * @param mixed $prixs entity
     *
     * @return self
     */
    public function addPrix($prixs): self
    {
        $prixs->setRefEvenement($this);
        $this->prixs->add($prixs);

        return $this;
    }

    /**
     * Remove prixs.
     *
     * @param mixed $prixs Entity
     *
     * @return self
     */
    public function removePrix($prixs): self
    {
        $this->prixs->removeElement($prixs);

        return $this;
    }

    /**
     * Add emplacements.
     *
     * @param mixed $emplacements entity
     *
     * @return self
     */
    public function addemplacement($emplacements): self
    {
        $emplacements->setRefEvenement($this);
        $this->emplacements->add($emplacements);

        return $this;
    }

    /**
     * Remove emplacements.
     *
     * @param mixed $emplacements Entity
     *
     * @return self
     */
    public function removeemplacement($emplacements): self
    {
        $this->emplacements->removeElement($emplacements);

        return $this;
    }

    /**
     * get emplacements.
     *
     * @return mixed
     */
    public function getEmplacements()
    {
        return $this->emplacements;
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
     * Recupere le nombre de place par emplacement.
     *
     * @return array
     */
    public function getEmplacementsAvecPlace(): array
    {
        $places       = [];
        $emplacements = $this->getEmplacements();
        foreach ($emplacements as $emplacement) {
            $totalPlaces = $emplacement->getDatesAvecPlace();
            if (count($totalPlaces) > 0) {
                $places[] = $emplacement;
            }
        }

        return $places;
    }

    /**
     * get the value of Totalnbdate.
     *
     * @return int
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
    public function setTotalnbdate($totalnbdate): self
    {
        $this->totalnbdate = $totalnbdate;

        return $this;
    }

    /**
     * Set the value of Prixs.
     *
     * @param array $prixs prixs
     *
     * @return self
     */
    public function setPrixs($prixs): self
    {
        $this->prixs = $prixs;

        return $this;
    }

    /**
     * Set the value of Emails.
     *
     * @param array $emails emails
     *
     * @return self
     */
    public function setEmails($emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Set the value of Telephones.
     *
     * @param array $telephones telephones
     *
     * @return self
     */
    public function setTelephones($telephones): self
    {
        $this->telephones = $telephones;

        return $this;
    }

    /**
     * Set the value of Liens.
     *
     * @param array $liens liens
     *
     * @return self
     */
    public function setLiens($liens): self
    {
        $this->liens = $liens;

        return $this;
    }

    /**
     * Set the value of Emplacements.
     *
     * @param array $emplacements emplacements
     *
     * @return self
     */
    public function setEmplacements($emplacements): self
    {
        $this->emplacements = $emplacements;

        return $this;
    }

    /**
     * get the value of Locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return (string) $this->locale;
    }

    /**
     * Set the value of Locale.
     *
     * @param string $locale locale
     *
     * @return self
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * get the value of Totalnbemplacement.
     *
     * @return int
     */
    public function getTotalnbemplacement(): int
    {
        return $this->totalnbemplacement;
    }

    /**
     * Set the value of Totalnbemplacement.
     *
     * @param int $totalnbemplacement totalnbemplacement
     *
     * @return self
     */
    public function setTotalnbemplacement(int $totalnbemplacement): self
    {
        $this->totalnbemplacement = $totalnbemplacement;

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
     * get the value of Publier.
     *
     * @return bool
     */
    public function isPublier(): bool
    {
        return $this->publier;
    }

    /**
     * Set the value of Publier.
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

    /**
     * get the value of Copyright.
     *
     * @return string
     */
    public function getCopyright(): string
    {
        return (string) $this->copyright;
    }

    /**
     * Set the value of Copyright.
     *
     * @param string $copyright copyright
     *
     * @return self
     */
    public function setCopyright(string $copyright): self
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * get the value of Type.
     *
     * @return bool
     */
    public function isType(): bool
    {
        return $this->type;
    }

    /**
     * Set the value of Type.
     *
     * @param bool $type type
     *
     * @return self
     */
    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Retour pour selec2.
     *
     * @return mixed
     */
    public function getCategorie()
    {
        $return = !is_object($this->getRefCategorie()) ? '' : $this->getRefCategorie()->getId();

        return $return;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setCategorie($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Champs créer pour champs Collection.
     *
     * @return array
     */
    public function getEmplacementadresses(): array
    {
        $adresses = [];
        foreach ($this->getEmplacements() as $emplacement) {
            foreach ($emplacement->getAdresses() as $adresse) {
                $adresses[] = $adresse;
            }
        }

        return $adresses;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setEmplacementadresses($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Champs créer pour champs Collection.
     *
     * @return array
     */
    public function getEtablissements(): array
    {
        $etablissements = [];
        foreach ($this->getEmplacements() as $emplacement) {
            $etablissement = $emplacement->getRefEtablissement();
            if (NULL !== $etablissement) {
                $etablissements[] = $etablissement;
            }
        }

        return $etablissements;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setEtablissements($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Get the value of File Vignette.
     *
     * @return string
     */
    public function getFileVignette(): string
    {
        return (string) $this->fileVignette;
    }

    /**
     * Set the value of File Vignette.
     *
     * @param string $fileVignette code MD5
     *
     * @return self
     */
    public function setFileVignette(string $fileVignette): self
    {
        $this->fileVignette = $fileVignette;

        return $this;
    }

    /**
     * Get the value of File Galerie.
     *
     * @return string
     */
    public function getFileGalerie(): string
    {
        return (string) $this->fileGalerie;
    }

    /**
     * Set the value of File Galerie.
     *
     * @param string $fileGalerie code MD5
     *
     * @return self
     */
    public function setFileGalerie(string $fileGalerie): self
    {
        $this->fileGalerie = $fileGalerie;

        return $this;
    }

    /**
     * Get the value of Updated At.
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At.
     *
     * @param DateTime $updatedAt date
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
