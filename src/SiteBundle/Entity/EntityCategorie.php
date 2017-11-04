<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

class EntityCategorie implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="categorie_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="refcategorie", cascade={"remove", "persist"})
     * @ORM\OrderBy({"position": "ASC", "nom": "ASC"})
     */
    protected $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="categories")
     * @ORM\JoinColumn(name="categorie_refcategorie", referencedColumnName="categorie_id", nullable=true)
     */
    protected $refcategorie;

    /**
     * @var string
     * @Gedmo\Translatable
     * @Gedmo\Slug(updatable=false, fields={"nom"})
     * @ORM\Column(name="categorie_alias", type="string")
     */
    protected $alias;

    /**
     * @var bool
     *
     * @ORM\Column(name="categorie_actif", type="boolean", nullable=true)
     */
    protected $actif;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="categorie_nom", type="text", nullable=true)
     */
    protected $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="categorie_position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="categorie_meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="categorie_meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_totalnbblog", type="integer", nullable=true, options={"default": 0})
     */
    protected $totalnbblog;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_totalnbpartenaire", type="integer", nullable=true, options={"default": 0})
     */
    protected $totalnbpartenaire;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_totalnbevenement", type="integer", nullable=true, options={"default": 0})
     */
    protected $totalnbevenement;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="refcategorie", cascade={"remove", "persist"})
     */
    protected $blogs;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Partenaire", mappedBy="refcategorie", cascade={"remove", "persist"})
     */
    protected $partenaires;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="refcategorie", cascade={"remove", "persist"})
     */
    protected $evenements;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_type", type="text", nullable=true)
     */
    protected $type;

    /**
     * @JMS\Exclude
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="child")
     * @ORM\JoinColumn(name="categorie_parent", referencedColumnName="categorie_id")
     * @ORM\OrderBy({"nom": "ASC"})
     */
    protected $parent;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"nom": "ASC"})
     */
    protected $child;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->totalnbblog       = 0;
        $this->totalnbpartenaire = 0;
        $this->totalnbevenement  = 0;
        $this->blogs             = new ArrayCollection();
        $this->partenaires       = new ArrayCollection();
        $this->categories        = new ArrayCollection();
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $nom    = [];
        $parent = $this->getParent();
        $nom[]  = $this->getNom();
        while (NULL !== $parent) {
            $nom[]  = $parent->getNom();
            $parent = $parent->getParent();
        }

        $nom = array_reverse($nom);

        $return = (string) implode(' > ', $nom);

        return $return;
    }

    /**
     * Add child.
     *
     * @param mixed $child entity
     *
     * @return self
     */
    public function addChild($child): self
    {
        $child->setParent($this);
        $this->child->add($child);

        return $this;
    }

    /**
     * Remove child.
     *
     * @param mixed $child Entity
     *
     * @return self
     */
    public function removeChild($child): self
    {
        $this->child->removeElement($child);

        return $this;
    }

    /**
     * Set parent.
     *
     * @param mixed $parent parent
     *
     * @return self
     */
    public function setParent($parent = NULL): self
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
     * Set nom.
     *
     * @param string $nom nom
     *
     * @return self
     */
    public function setNom($nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add blogs.
     *
     * @param mixed $blogs entity
     *
     * @return self
     */
    public function addBlog($blogs): self
    {
        $blogs->setRefCategorie($this);
        $this->blogs->add($blogs);

        return $this;
    }

    /**
     * Remove blogs.
     *
     * @param mixed $blogs Entity
     *
     * @return self
     */
    public function removeBlog($blogs): self
    {
        $this->blogs->removeElement($blogs);

        return $this;
    }

    /**
     * get blogs.
     *
     * @return mixed
     */
    public function getBlogs()
    {
        return $this->blogs;
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
     * Add partenaires.
     *
     * @param mixed $partenaires entity
     *
     * @return self
     */
    public function addPartenaire($partenaires): self
    {
        $partenaires->setRefCategorie($this);
        $this->partenaires->add($partenaires);

        return $this;
    }

    /**
     * Remove blogs.
     *
     * @param mixed $partenaires Entity
     *
     * @return self
     */
    public function removePartenaire($partenaires): self
    {
        $this->partenaires->removeElement($partenaires);

        return $this;
    }

    /**
     * get categories.
     *
     * @return mixed
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * Set actif.
     *
     * @param bool $actif bool
     *
     * @return self
     */
    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * get actif.
     *
     * @return bool
     */
    public function isActif(): bool
    {
        return (bool) $this->actif;
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
     * get the value of Totalnbblog.
     *
     * @return int
     */
    public function getTotalnbblog(): int
    {
        return $this->totalnbblog;
    }

    /**
     * Set the value of Totalnbblog.
     *
     * @param int $totalnbblog totalnbblog
     *
     * @return self
     */
    public function setTotalnbblog(int $totalnbblog): self
    {
        $this->totalnbblog = $totalnbblog;

        return $this;
    }

    /**
     * get the value of Totalnbpartenaire.
     *
     * @return string
     */
    public function getTotalnbpartenaire(): int
    {
        return $this->totalnbpartenaire;
    }

    /**
     * Set the value of Totalnbpartenaire.
     *
     * @param int $totalnbpartenaire totalnbpartenaire
     *
     * @return self
     */
    public function setTotalnbpartenaire(int $totalnbpartenaire): self
    {
        $this->totalnbpartenaire = $totalnbpartenaire;

        return $this;
    }

    /**
     * Set the value of Blogs.
     *
     * @param mixed $blogs blogs
     *
     * @return self
     */
    public function setBlogs($blogs): self
    {
        $this->blogs = $blogs;

        return $this;
    }

    /**
     * Set the value of Partenaires.
     *
     * @param mixed $partenaires partenaires
     *
     * @return self
     */
    public function setPartenaires($partenaires): self
    {
        $this->partenaires = $partenaires;

        return $this;
    }

    /**
     * NE PAS UTILISER
     * Set the value of Child.
     *
     * @param mixed $child child
     *
     * @return self
     */
    public function setChild($child): self
    {
        $this->child = $child;

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
     * get the value of Evenements.
     *
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * Set the value of Evenements.
     *
     * @param mixed $evenements evenements
     *
     * @return self
     */
    public function setEvenements($evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }

    /**
     * Get the value of Totalnbevenement.
     *
     * @return int
     */
    public function getTotalnbevenement(): int
    {
        return $this->totalnbevenement;
    }

    /**
     * Set the value of Totalnbevenement.
     *
     * @param int $totalnbevenement totalnbevenement
     *
     * @return self
     */
    public function setTotalnbevenement(int $totalnbevenement): self
    {
        $this->totalnbevenement = $totalnbevenement;

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
            'nom' => $this->getNom(),
        ];

        return $tab;
    }

    /**
     * Add categorie.
     *
     * @param mixed $categorie entity
     *
     * @return self
     */
    public function addCategorie($categorie): self
    {
        $categorie->setRefCategorie($this);
        $this->categories->add($categorie);

        return $this;
    }

    /**
     * Remove categorie.
     *
     * @param mixed $categorie Entity
     *
     * @return self
     */
    public function removeCategorie($categorie): self
    {
        $this->categories->removeElement($categorie);

        return $this;
    }

    /**
     * get categories.
     *
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set refcategorie.
     *
     * @param mixed $refcategorie refcategorie
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
}
