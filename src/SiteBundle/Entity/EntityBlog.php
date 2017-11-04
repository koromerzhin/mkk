<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityBlog
{
    /**
     * @var int
     *
     * @ORM\Column(name="blog_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="blog_accueil", type="boolean", nullable=true)
     */
    protected $accueil;

    /**
     * @var bool
     *
     * @ORM\Column(name="blog_commentaire", type="boolean", nullable=true)
     */
    protected $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_langue", type="text", nullable=true)
     */
    protected $langue;

    /**
     * @var string
     * @Gedmo\Slug(updatable=false, fields={"titre"})
     * @ORM\Column(name="blog_alias", type="string")
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_titre", type="text", nullable=true)
     */
    protected $titre;

    /**
     * @var bool
     *
     * @ORM\Column(name="blog_actif_public", type="boolean", nullable=true)
     */
    protected $actifPublic;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_vignette", type="string", nullable=true)
     */
    protected $vignette;

    /**
     * @UploadableField(filename="vignette", path="blog/vignette", unique=true, alias="titre")
     */
    protected $fileVignette;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_image", type="string", nullable=true)
     */
    protected $image;

    /**
     * @UploadableField(filename="image", path="blog/image", unique=true, alias="titre")
     */
    protected $fileImage;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="blog_galerie", type="array", nullable=true)
     */
    protected $galerie;

    /**
     * @UploadableField(filename="galerie", path="blog/galerie", unique=false, alias="titre")
     */
    protected $fileGalerie;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_intro", type="text", nullable=true)
     */
    protected $intro;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_contenu", type="text", nullable=true)
     */
    protected $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="blog_datecreation", type="integer", nullable=true)
     */
    protected $datecreation;

    /**
     * @var int
     *
     * @ORM\Column(name="blog_datepublication", type="integer", nullable=true)
     */
    protected $datepublication;

    /**
     * @var int
     *
     * @ORM\Column(name="blog_datemodif", type="integer", nullable=true)
     */
    protected $datemodif;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="blogs")
     * @ORM\JoinColumn(name="blog_refuser", referencedColumnName="user_id")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="blogs")
     * @ORM\JoinColumn(name="blog_refcategorie", referencedColumnName="categorie_id")
     */
    protected $refcategorie;

    /**
     * @ORM\ManyToMany(targetEntity="Tag",  mappedBy="blogs")
     */
    protected $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_video", type="string", nullable=true)
     */
    protected $video;

    /**
     * @var bool
     *
     * @ORM\Column(name="blog_avant", type="boolean", nullable=true)
     */
    protected $avant;

    /**
     * @var bool
     *
     * @ORM\Column(name="blog_redacteur", type="boolean", nullable=true)
     */
    protected $redacteur;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->galerie = [];
        $this->tags    = new ArrayCollection();
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
     * Set langue.
     *
     * @param string $langue langue
     *
     * @return self
     */
    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * get langue.
     *
     * @return string
     */
    public function getLangue(): string
    {
        return (string) $this->langue;
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
     * Set the value of Actif Public.
     *
     * @param bool $actifPublic boolean
     *
     * @return self
     */
    public function setActifPublic(bool $actifPublic): self
    {
        $this->actifPublic = $actifPublic;

        return $this;
    }

    /**
     * get actif_public.
     *
     * @return string
     */
    public function isActifPublic(): bool
    {
        return (bool) $this->actifPublic;
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
     * Set galerie.
     *
     * @param array $galerie fichiers
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
     * Set intro.
     *
     * @param string $intro intro
     *
     * @return self
     */
    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * get intro.
     *
     * @return string
     */
    public function getIntro(): string
    {
        return (string) $this->intro;
    }

    /**
     * Set datecreation.
     *
     * @param int $datecreation datecreation
     *
     * @return self
     */
    public function setDatecreation(int $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * get datecreation.
     *
     * @return mixed
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set datemodif.
     *
     * @param int $datemodif datemodif
     *
     * @return self
     */
    public function setDatemodif(int $datemodif): self
    {
        $this->datemodif = $datemodif;

        return $this;
    }

    /**
     * get datemodif.
     *
     * @return mixed
     */
    public function getDatemodif()
    {
        return $this->datemodif;
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
     * Set video.
     *
     * @param string $video video
     *
     * @return self
     */
    public function setVideo(string $video): self
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
     * Add tags.
     *
     * @param mixed $tags entity
     *
     * @return self
     */
    public function addTag($tags): self
    {
        $this->tags->add($tags);

        return $this;
    }

    /**
     * Remove tags.
     *
     * @param mixed $tags Entity
     *
     * @return self
     */
    public function removeTag($tags): self
    {
        $this->tags->removeElement($tags);

        return $this;
    }

    /**
     * get tags.
     *
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set image.
     *
     * @param string $image image
     *
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * get image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return (string) $this->image;
    }

    /**
     * Set datepublication.
     *
     * @param int $datepublication date de publication
     *
     * @return self
     */
    public function setDatepublication($datepublication): self
    {
        if (0 !== substr_count($datepublication, ' ')) {
            list($date, $horaire)      = explode(' ', $datepublication);
            list($jour, $mois, $annee) = explode('/', $date);
            list($heure, $minute)      = explode(':', $horaire);
            $this->datepublication     = mktime($heure, $minute, 0, $mois, $jour, $annee);
        } else {
            $this->datepublication = $datepublication;
        }

        return $this;
    }

    /**
     * get datepublication.
     *
     * @return int
     */
    public function getDatepublication()
    {
        return $this->datepublication;
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
        return (bool) $this->accueil;
    }

    /**
     * Set avant.
     *
     * @param bool $avant avant
     *
     * @return self
     */
    public function setAvant(bool $avant): self
    {
        $this->avant = $avant;

        return $this;
    }

    /**
     * get avant.
     *
     * @return bool
     */
    public function isAvant(): bool
    {
        return (bool) $this->avant;
    }

    /**
     * Set redacteur.
     *
     * @param bool $redacteur bool
     *
     * @return self
     */
    public function setRedacteur(bool $redacteur): self
    {
        $this->redacteur = $redacteur;

        return $this;
    }

    /**
     * get redacteur.
     *
     * @return bool
     */
    public function isRedacteur(): bool
    {
        return (bool) $this->redacteur;
    }

    /**
     * get the value of Commentaire.
     *
     * @return bool
     */
    public function isCommentaire(): bool
    {
        return (bool) $this->commentaire;
    }

    /**
     * Set the value of Commentaire.
     *
     * @param bool $commentaire commentaire
     *
     * @return self
     */
    public function setCommentaire(bool $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Set the value of Tags.
     *
     * @param mixed $tags tags
     *
     * @return self
     */
    public function setTags($tags): self
    {
        $this->tags = $tags;

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
     * @param srting $fileVignette code MD5
     *
     * @return self
     */
    public function setFileVignette(string $fileVignette): self
    {
        $this->fileVignette = $fileVignette;

        return $this;
    }

    /**
     * Get the value of File Image.
     *
     * @return string
     */
    public function getFileImage(): string
    {
        return (string) $this->fileImage;
    }

    /**
     * Set the value of File Image.
     *
     * @param string $fileImage code MD5
     *
     * @return self
     */
    public function setFileImage(string $fileImage): self
    {
        $this->fileImage = $fileImage;

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
}
