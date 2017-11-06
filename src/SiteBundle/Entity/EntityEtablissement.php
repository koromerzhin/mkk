<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityEtablissement implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="etablissement_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Etablissement", mappedBy="refetablissement", cascade={"remove", "persist"})
     * @ORM\OrderBy({"position": "ASC", "nom": "ASC"})
     */
    protected $etablissements;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="etablissements")
     * @ORM\JoinColumn(name="etablissement_refetablissement", referencedColumnName="etablissement_id", nullable=true)
     */
    protected $refetablissement;

    /**
     * @ORM\ManyToOne(targetEntity="NafSousClasse", inversedBy="etablissements")
     * @ORM\JoinColumn(name="etablissement_refnafsousclasse", referencedColumnName="nafsousclasse_id", nullable=true)
     */
    protected $refnafsousclasse;

    /**
     * @Gedmo\Slug(updatable=false, fields={"prefix", "nom"})
     * @ORM\Column(name="etablissement_alias", type="string")
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_prefix", type="text", nullable=true)
     */
    protected $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_nom", type="text", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_directeur", type="text", nullable=true)
     */
    protected $directeur;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_raisonsociale", type="text", nullable=true)
     */
    protected $raisonsociale;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_formejuridique", type="text", nullable=true)
     */
    protected $formejuridique;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_siret", type="text", nullable=true)
     */
    protected $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_ca", type="text", nullable=true)
     */
    protected $ca;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_ape", type="text", nullable=true)
     */
    protected $ape;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_tvaintra", type="text", nullable=true)
     */
    protected $tvaintra;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="etablissement_descriptionactivite", type="text", nullable=true)
     */
    protected $descriptionactivite;

    /**
     * @ORM\Column(name="etablissement_copyright", type="text", nullable=true)
     */
    protected $copyright;

    /**
     * @var bool
     *
     * @ORM\Column(name="etablissement_actif", type="boolean", nullable=true)
     */
    protected $actif;

    /**
     * @var int
     *
     * @ORM\Column(name="etablissement_position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_vignette", type="string", nullable=true)
     */
    protected $vignette;

    /**
     * @UploadableField(filename="vignette", path="etablissement/vignette", unique=true, alias="nom")
     */
    protected $fileVignette;

    /**
     * @var array
     *
     * @ORM\Column(name="etablissement_pdf", type="array", length=255, nullable=true)
     */
    protected $pdf;

    /**
     * @UploadableField(filename="pdf", path="etablissement/pdf", unique=false, alias="nom")
     */
    protected $filePdf;

    /**
     * @var array
     *
     * @ORM\Column(name="etablissement_galerie", type="array", nullable=true)
     */
    protected $galerie;

    /**
     * @UploadableField(filename="galerie", path="etablissement/galerie", unique=false, alias="nom")
     */
    protected $fileGalerie;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_vuesinterne", type="array", nullable=true)
     */
    protected $vuesinterne;

    /**
     * @UploadableField(filename="vuesinterne", path="etablissement/vuesinterne", unique=false, alias="nom")
     */
    protected $fileVuesinterne;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_vuesexterne", type="array", nullable=true)
     */
    protected $vuesexterne;

    /**
     * @UploadableField(filename="vuesexterne", path="etablissement/vuesexterne", unique=false, alias="nom")
     */
    protected $fileVuesexterne;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_vuesequipe", type="array", nullable=true)
     */
    protected $vuesequipe;

    /**
     * @UploadableField(filename="vuesequipe", path="etablissement/vuesequipe", unique=false, alias="nom")
     */
    protected $fileVuesequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var int
     *
     * @ORM\Column(name="etablissement_nbsalarie", type="integer", nullable=true)
     */
    protected $nbsalarie;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_video", type="string", nullable=true)
     */
    protected $video;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_activite", type="string", nullable=true)
     */
    protected $activite;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_accueil", type="boolean", nullable=true)
     */
    protected $accueil;

    /**
     * @JMS\Exclude
     * @ORM\ManyToMany(targetEntity="User", inversedBy="etablissements", cascade={"remove", "persist"})
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="refetablissement", referencedColumnName="etablissement_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="refuser", referencedColumnName="user_id")}
     * )
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="refetablissement", cascade={"all"})
     */
    protected $emails;

    /**
     * @ORM\OneToMany(targetEntity="Lien", mappedBy="refetablissement", cascade={"all"})
     */
    protected $liens;

    /**
     * @ORM\OneToMany(targetEntity="Horaire", mappedBy="refetablissement", cascade={"all"})
     * @ORM\OrderBy({"jour": "ASC"})
     */
    protected $horaires;

    /**
     * @ORM\OneToMany(targetEntity="Telephone", mappedBy="refetablissement", cascade={"all"})
     */
    protected $telephones;

    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="refetablissement", cascade={"all"})
     */
    protected $adresses;

    /**
     * @ORM\OneToMany(targetEntity="Etablissement", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"position": "ASC"})
     * @JMS\Exclude
     */
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="child")
     * @ORM\JoinColumn(name="etablissement_parent", referencedColumnName="etablissement_id")
     */
    protected $parent;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="Emplacement", mappedBy="refetablissement", cascade={"all"})
     */
    protected $emplacements;
    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Init.
     */
    public function __construct()
    {
        $this->actif      = 0;
        $this->liens      = new ArrayCollection();
        $this->emails     = new ArrayCollection();
        $this->telephones = new ArrayCollection();
        $this->horaires   = new ArrayCollection();
        $this->users      = new ArrayCollection();
        $this->pdf        = [];
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getNom();

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
     * Set accueil.
     *
     * @param bool $accueil accueil
     *
     * @return self
     */
    public function setAccueil(bool $accueil): self
    {
        $this->accueil = $accueil;

        return $this;
    }

    /**
     * get accueil.
     *
     * @return string
     */
    public function isAccueil(): bool
    {
        return $this->accueil;
    }

    /**
     * Set actif.
     *
     * @param bool $actifPublic actif
     *
     * @return self
     */
    public function setActif(bool $actifPublic): self
    {
        $this->actif = $actifPublic;

        return $this;
    }

    /**
     * get actif.
     *
     * @return string
     */
    public function isActif(): bool
    {
        return (bool) $this->actif;
    }

    /**
     * Set siret.
     *
     * @param mixed $siret siret
     *
     * @return self
     */
    public function setSiret($siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * get siret.
     *
     * @return string
     */
    public function getSiret(): string
    {
        return (string) $this->siret;
    }

    /**
     * Set ca.
     *
     * @param mixed $ca ca
     *
     * @return self
     */
    public function setCa($ca): self
    {
        $this->ca = $ca;

        return $this;
    }

    /**
     * get ca.
     *
     * @return string
     */
    public function getCa(): string
    {
        return (string) $this->ca;
    }

    /**
     * Set ape.
     *
     * @param mixed $ape ape
     *
     * @return self
     */
    public function setApe($ape): self
    {
        $this->ape = $ape;

        return $this;
    }

    /**
     * get ape.
     *
     * @return string
     */
    public function getApe(): string
    {
        return (string) $this->ape;
    }

    /**
     * Set tvaintra.
     *
     * @param mixed $tvaintra tvaintra
     *
     * @return self
     */
    public function setTvaintra($tvaintra): self
    {
        $this->tvaintra = $tvaintra;

        return $this;
    }

    /**
     * get tvaintra.
     *
     * @return string
     */
    public function getTvaintra(): string
    {
        return (string) $this->tvaintra;
    }

    /**
     * Set descriptionactivite.
     *
     * @param mixed $descriptionactivite descriptionactivite
     *
     * @return self
     */
    public function setDescriptionactivite($descriptionactivite): self
    {
        $this->descriptionactivite = $descriptionactivite;

        return $this;
    }

    /**
     * get descriptionactivite.
     *
     * @return string
     */
    public function getDescriptionactivite(): string
    {
        return (string) $this->descriptionactivite;
    }

    /**
     * Set video.
     *
     * @param mixed $video video
     *
     * @return self
     */
    public function setVideo($video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * get video.
     *
     * @return string
     */
    public function getVideo(): string
    {
        return (string) $this->video;
    }

    /**
     * Set galerie.
     *
     * @param array $galerie galerie
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
     * Set the value of Meta Description.
     *
     * @param mixed $metaDescription meta description
     *
     * @return self
     */
    public function setMetaDescription($metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * get meta_description.
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return (string) $this->metaDescription;
    }

    /**
     * Set the value of Meta Keywords.
     *
     * @param mixed $metaKeywords Meta keywords
     *
     * @return self
     */
    public function setMetaKeywords($metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * get the value of Meta Keywords.
     *
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return (string) $this->metaKeywords;
    }

    /**
     * Set nbsalarie.
     *
     * @param int $nbsalarie nombre de salarié
     *
     * @return self
     */
    public function setNbsalarie(int $nbsalarie): self
    {
        $this->nbsalarie = $nbsalarie;

        return $this;
    }

    /**
     * get nbsalarie.
     *
     * @return int
     */
    public function getNbsalarie(): int
    {
        return (int) $this->nbsalarie;
    }

    /**
     * Set nom.
     *
     * @param string $nom nom
     *
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = mb_strtoupper($nom, 'UTF-8');

        return $this;
    }

    /**
     * get nom.
     *
     * @return string
     */
    public function getNom(): string
    {
        $return = mb_strtoupper($this->nom, 'UTF-8');

        return (string) $return;
    }

    /**
     * Set the value of Position.
     *
     * @param int $position chiffre
     *
     * @return self
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * get position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->position;
    }

    /**
     * Set raisonsociale.
     *
     * @param string $raisonsociale raison soclale
     *
     * @return self
     */
    public function setRaisonsociale(string $raisonsociale): self
    {
        $this->raisonsociale = $raisonsociale;

        return $this;
    }

    /**
     * get raisonsociale.
     *
     * @return string
     */
    public function getRaisonsociale(): string
    {
        return (string) $this->raisonsociale;
    }

    /**
     * Set formejuridique.
     *
     * @param string $formejuridique forme juridique
     *
     * @return self
     */
    public function setFormejuridique(string $formejuridique): self
    {
        $this->formejuridique = $formejuridique;

        return $this;
    }

    /**
     * get formejuridique.
     *
     * @return string
     */
    public function getFormejuridique(): string
    {
        return (string) $this->formejuridique;
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
     * Add users.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addUser($row): self
    {
        $this->users->add($row);

        return $this;
    }

    /**
     * Remove users.
     *
     * @param mixed $user Entity
     *
     * @return self
     */
    public function removeUser($user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * get users.
     *
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add child.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addChild($row): self
    {
        $row->setParent($this);
        $this->child->add($row);

        return $this;
    }

    /**
     * Add child. (NE PLUS UTILISER).
     *
     * @param array $childs childs
     *
     * @return self
     */
    public function setChild($childs): self
    {
        $this->child = $childs;

        return $this;
    }

    /**
     * get child.
     *
     * @return mixed
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set parent. (NE PLUS UTILISER).
     *
     * @param mixed $parent parent
     *
     * @return self
     */
    public function setParent($parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * get parent.
     *
     * @return self
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add emails.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addEmail($row): self
    {
        $row->setRefEtablissement($this);
        $this->emails->add($row);

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
     * @param mixed $row entity
     *
     * @return self
     */
    public function addLien($row): self
    {
        $row->setRefEtablissement($this);
        $this->liens->add($row);

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
     * Add horaires.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addHoraire($row): self
    {
        $row->setRefEtablissement($this);
        $this->horaires->add($row);

        return $this;
    }

    /**
     * Remove horaires.
     *
     * @param mixed $horaires Entity
     *
     * @return self
     */
    public function removeHoraire($horaires): self
    {
        $this->horaires->removeElement($horaires);

        return $this;
    }

    /**
     * get horaires.
     *
     * @return mixed
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * Add adresses.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addAdress($row): self
    {
        $row->setRefEtablissement($this);
        $this->adresses->add($row);

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
     * Add telephones.
     *
     * @param mixed $telephone entity
     *
     * @return self
     */
    public function addTelephone($telephone): self
    {
        $telephone->setRefEtablissement($this);
        $this->telephones->add($telephone);

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
     * Set the value of Users.
     *
     * @param array $users users
     *
     * @return self
     */
    public function setUsers($users): self
    {
        $this->users = $users;

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
     * Set the value of Horaires.
     *
     * @param array $horaires horaires
     *
     * @return self
     */
    public function setHoraires($horaires): self
    {
        $this->horaires = $horaires;

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
     * get the value of Vuesinterne.
     *
     * @return array
     */
    public function getVuesinterne(): array
    {
        return $this->vuesinterne;
    }

    /**
     * Set the value of Vuesinterne.
     *
     * @param array $vuesinterne vuesinterne
     *
     * @return self
     */
    public function setVuesinterne(array $vuesinterne): self
    {
        $this->vuesinterne = $vuesinterne;

        return $this;
    }

    /**
     * get the value of Vuesexterne.
     *
     * @return array
     */
    public function getVuesexterne(): array
    {
        return $this->vuesexterne;
    }

    /**
     * Set the value of Vuesexterne.
     *
     * @param array $vuesexterne vuesexterne
     *
     * @return self
     */
    public function setVuesexterne(array $vuesexterne): self
    {
        $this->vuesexterne = $vuesexterne;

        return $this;
    }

    /**
     * get the value of Locale.
     *
     * @return mixed
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
     * get the value of Vuesequipe.
     *
     * @return array
     */
    public function getVuesequipe(): array
    {
        return $this->vuesequipe;
    }

    /**
     * Set the value of Vuesequipe.
     *
     * @param array $vuesequipe vuesequipe
     *
     * @return self
     */
    public function setVuesequipe(array $vuesequipe): self
    {
        $this->vuesequipe = $vuesequipe;

        return $this;
    }

    /**
     * Add emplacements.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addEmplacement($row): self
    {
        $row->setRefEtablissement($this);
        $this->emplacements->add($row);

        return $this;
    }

    /**
     * Remove emplacements.
     *
     * @param mixed $emplacements Entity
     *
     * @return self
     */
    public function removeEmplacement($emplacements): self
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
     * get the value of Directeur.
     *
     * @return string
     */
    public function getDirecteur(): string
    {
        return (string) $this->directeur;
    }

    /**
     * Set the value of Directeur.
     *
     * @param mixed $directeur directeur
     *
     * @return self
     */
    public function setDirecteur($directeur): self
    {
        $this->directeur = $directeur;

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
     * get the value of Copyright.
     *
     * @return mixed
     */
    public function getCopyright(): string
    {
        return (string) $this->copyright;
    }

    /**
     * Set the value of Copyright.
     *
     * @param mixed $copyright copyright
     *
     * @return self
     */
    public function setCopyright($copyright): self
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * get the value of Prefix.
     *
     * @return text
     */
    public function getPrefix(): string
    {
        return (string) $this->prefix;
    }

    /**
     * Set the value of Prefix.
     *
     * @param mixed $prefix prefix
     *
     * @return self
     */
    public function setPrefix($prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Fonction pour les resultats de select2.
     *
     * @return array
     */
    public function getSearchData(): array
    {
        $tab = [
            'id'  => $this->getId(),
            'nom' => $this->__toString(),
        ];

        return $tab;
    }

    /**
     * Add etablissement.
     *
     * @param mixed $row entity
     *
     * @return self
     */
    public function addEtablissement($row)
    {
        $row->setRefEtablissement($this);
        $this->etablissements->add($row);

        return $this;
    }

    /**
     * Remove etablissement.
     *
     * @param mixed $etablissement Entity
     *
     * @return self
     */
    public function removeEtablissement($etablissement): self
    {
        $this->etablissements->removeElement($etablissement);

        return $this;
    }

    /**
     * get etablissements.
     *
     * @return mixed
     */
    public function getEtablissements()
    {
        return $this->etablissements;
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
     * @return self
     */
    public function getRefEtablissement()
    {
        return $this->refetablissement;
    }

    /**
     * Get the value of Refnafsousclasse.
     *
     * @return mixed
     */
    public function getRefNafSousClasse()
    {
        return $this->refnafsousclasse;
    }

    /**
     * Retour pour selec2.
     *
     * @return mixed
     */
    public function getNafSousClasse()
    {
        $return = !is_object($this->getRefNafSousClasse()) ? '' : $this->getRefNafSousClasse()->getId();

        return $return;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setNafSousClasse($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Set the value of Etablissements.
     *
     * @param array $etablissements Sous etablissement
     *
     * @return self
     */
    public function setEtablissements($etablissements): self
    {
        $this->etablissements = $etablissements;

        return $this;
    }

    /**
     * Set the value of Refnafsousclasse.
     *
     * @param mixed $refnafsousclasse Entity
     *
     * @return self
     */
    public function setRefNafsousclasse($refnafsousclasse): self
    {
        $this->refnafsousclasse = $refnafsousclasse;

        return $this;
    }

    /**
     * Get the value of Activite.
     *
     * @return string
     */
    public function getActivite(): string
    {
        return (string) $this->activite;
    }

    /**
     * Set the value of Activite.
     *
     * @param mixed $activite activite
     *
     * @return self
     */
    public function setActivite($activite): self
    {
        $this->activite = $activite;

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

    /**
     * Get the value of Pdf.
     *
     * @return array
     */
    public function getPdf(): array
    {
        return (array) $this->pdf;
    }

    /**
     * Set the value of Pdf.
     *
     * @param array $pdf pdf
     *
     * @return self
     */
    public function setPdf(array $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get the value of File Pdf.
     *
     * @return string
     */
    public function getFilePdf(): string
    {
        return (string) $this->filePdf;
    }

    /**
     * Set the value of File Pdf.
     *
     * @param string $filePdf code MD5
     *
     * @return self
     */
    public function setFilePdf(string $filePdf): self
    {
        $this->filePdf = $filePdf;

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
     * Get the value of File Vuesinterne.
     *
     * @return string
     */
    public function getFileVuesinterne(): string
    {
        return (string) $this->fileVuesinterne;
    }

    /**
     * Set the value of File Vuesinterne.
     *
     * @param string $fileVuesinterne code MD5
     *
     * @return self
     */
    public function setFileVuesinterne(string $fileVuesinterne): self
    {
        $this->fileVuesinterne = $fileVuesinterne;

        return $this;
    }

    /**
     * Get the value of File Vuesexterne.
     *
     * @return string
     */
    public function getFileVuesexterne(): string
    {
        return (string) $this->fileVuesexterne;
    }

    /**
     * Set the value of File Vuesexterne.
     *
     * @param string $fileVuesexterne code MD5
     *
     * @return self
     */
    public function setFileVuesexterne(string $fileVuesexterne): self
    {
        $this->fileVuesexterne = $fileVuesexterne;

        return $this;
    }

    /**
     * Get the value of File Vuesequipe.
     *
     * @return string
     */
    public function getFileVuesequipe(): string
    {
        return (string) $this->fileVuesequipe;
    }

    /**
     * Set the value of File Vuesequipe.
     *
     * @param string $fileVuesequipe code MD5
     *
     * @return self
     */
    public function setFileVuesequipe(string $fileVuesequipe): self
    {
        $this->fileVuesequipe = $fileVuesequipe;

        return $this;
    }
}
