<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class EntityMenu implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="menu_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="refmenu", cascade={"remove", "persist"})
     * @ORM\OrderBy({"position": "ASC"})
     */
    protected $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     * @ORM\JoinColumn(name="menu_refmenu", referencedColumnName="menu_id", nullable=true)
     */
    protected $refmenu;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="child")
     * @ORM\JoinColumn(name="menu_parent", referencedColumnName="menu_id", nullable=true)
     */
    protected $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_clef", type="string", nullable=true)
     */
    protected $clef;

    /**
     * @var bool
     *
     * @ORM\Column(name="menu_separateur", type="boolean")
     */
    protected $separateur;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="menu_libelle", type="text", nullable=true)
     */
    protected $libelle;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="menu_description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var array
     *
     * @ORM\Column(name="menu_data", type="array", nullable=true)
     */
    protected $data;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="menu_url", type="string", nullable=true)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_cible", type="string", nullable=true)
     */
    protected $cible;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_image", type="string", nullable=true)
     */
    protected $image;

    /**
     * @var int
     *
     * @ORM\Column(name="menu_position", type="integer", options={"default": 0})
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_refgroup", type="string", nullable=true)
     */
    protected $refgroup;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent", cascade={"remove", "persist"})
     * @ORM\OrderBy({"position": "ASC"})
     */
    protected $child;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_icon", type="string", nullable=true)
     */
    protected $icon;

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
        $this->separateur = 0;
        $this->position   = 0;
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getLibelle();

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
     * Set parent.
     *
     * @param mixed $parent Menu
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
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set clef.
     *
     * @param string $clef clef
     *
     * @return self
     */
    public function setClef(string $clef): self
    {
        $this->clef = $clef;
    }

    /**
     * get clef.
     *
     * @return string
     */
    public function getClef(): string
    {
        return (string) $this->clef;
    }

    /**
     * Set separateur.
     *
     * @param bool $separateur separateur
     *
     * @return self
     */
    public function setSeparateur(bool $separateur): self
    {
        $this->separateur = $separateur;

        return $this;
    }

    /**
     * get separateur.
     *
     * @return bool
     */
    public function isSeparateur(): bool
    {
        return $this->separateur;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle libelle
     *
     * @return self
     */
    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * get libelle.
     *
     * @return string
     */
    public function getLibelle(): string
    {
        return (string) $this->libelle;
    }

    /**
     * Set url.
     *
     * @param string $url url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return self;
    }

    /**
     * get url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        $url = (string) $this->url;
        if ('user_logout' === $url) {
            $url = 'fos_user_security_logout';
        }

        return $url;
    }

    /**
     * Set cible.
     *
     * @param string $cible cible
     *
     * @return self
     */
    public function setCible($cible): self
    {
        $this->cible = $cible;

        return $this;
    }

    /**
     * get cible.
     *
     * @return string
     */
    public function getCible()
    {
        return $this->cible;
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
     * Set the value of Position.
     *
     * @param int $position chiffre
     *
     * @return self
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;
    }

    /**
     * get position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Set refgroup.
     *
     * @param string $refgroup Group
     *
     * @return self
     */
    public function setRefGroup($refgroup): self
    {
        $this->refgroup = $refgroup;

        return $this;
    }

    /**
     * get refgroup.
     *
     * @return string
     */
    public function getRefGroup()
    {
        return $this->refgroup;
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
     * Add child.
     *
     * @param mixed $childs Menu
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
     * Set param.
     *
     * @param array $data data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * get param.
     *
     * @return text
     */
    public function getData(): array
    {
        return $this->data;
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
     * Set icon.
     *
     * @param string $icon icon
     *
     * @return self
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * get icon.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return (string) $this->icon;
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
     * Add menu.
     *
     * @param mixed $menu entity
     *
     * @return self
     */
    public function addMenu($menu): self
    {
        $menu->setRefmenu($this);
        $this->menus->add($menu);

        return $this;
    }

    /**
     * Remove menu.
     *
     * @param mixed $menu Entity
     *
     * @return self
     */
    public function removeMenu($menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

    /**
     * get menus.
     *
     * @return mixed
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set refmenu.
     *
     * @param mixed $refmenu Entité menu
     *
     * @return self
     */
    public function setRefMenu($refmenu = NULL): self
    {
        $this->refmenu = $refmenu;

        return $this;
    }

    /**
     * get refmenu.
     *
     * @return mixed
     */
    public function getRefMenu()
    {
        return $this->refmenu;
    }
}
