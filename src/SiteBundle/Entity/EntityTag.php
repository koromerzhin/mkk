<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

class EntityTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="tag_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Slug(updatable=false, fields={"nom"})
     * @ORM\Column(name="tag_alias", type="string")
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_nom", type="text", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_totalnbblog", type="integer")
     */
    protected $totalnbblog;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_totalnbbookmark", type="integer")
     */
    protected $totalnbbookmark;

    /**
     * @JMS\Exclude
     * @ORM\ManyToMany(targetEntity="Blog", inversedBy="tags", cascade={"remove", "persist"})
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="reftag", referencedColumnName="tag_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="refblog", referencedColumnName="blog_id")}
     * )
     */
    protected $blogs;

    /**
     * @JMS\Exclude
     * @ORM\ManyToMany(targetEntity="Bookmark", inversedBy="tags", cascade={"remove", "persist"})
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="reftag", referencedColumnName="tag_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="refbookmark", referencedColumnName="bookmark_id")}
     * )
     */
    protected $bookmarks;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->totalnbblog     = 0;
        $this->totalnbbookmark = 0;
        $this->blogs           = new ArrayCollection();
        $this->bookmarks       = new ArrayCollection();
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
     * Set nom.
     *
     * @param string $nom string
     *
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * get nom.
     *
     * @return string
     */
    public function getNom(): string
    {
        return (string) $this->nom;
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
     * Add bookmarks.
     *
     * @param mixed $bookmarks entity
     *
     * @return self
     */
    public function addBookmark($bookmarks): self
    {
        $this->bookmarks->add($bookmarks);

        return $this;
    }

    /**
     * Remove bookmarks.
     *
     * @param mixed $bookmarks Entity
     *
     * @return self
     */
    public function removeBookmark($bookmarks): self
    {
        $this->bookmarks->removeElement($bookmarks);

        return $this;
    }

    /**
     * get bookmarks.
     *
     * @return mixed
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
    }

    /**
     * get the value of Totalnbblog.
     *
     * @return string
     */
    public function getTotalnbblog(): int
    {
        return $this->totalnbblog;
    }

    /**
     * Set the value of Totalnbblog.
     *
     * @param int $totalnbblog total
     *
     * @return self
     */
    public function setTotalnbblog(int $totalnbblog): self
    {
        $this->totalnbblog = $totalnbblog;

        return $this;
    }

    /**
     * get the value of Totalnbbookmark.
     *
     * @return string
     */
    public function getTotalnbbookmark(): int
    {
        return $this->totalnbbookmark;
    }

    /**
     * Set the value of Totalnbbookmark.
     *
     * @param int $totalnbbookmark total
     *
     * @return self
     */
    public function setTotalnbbookmark(int $totalnbbookmark): self
    {
        $this->totalnbbookmark = $totalnbbookmark;

        return $this;
    }

    /**
     * Set the value of Blogs.
     *
     * @param mixed $blogs entité
     *
     * @return self
     */
    public function setBlogs($blogs): self
    {
        $this->blogs = $blogs;

        return $this;
    }

    /**
     * Set the value of Bookmarks.
     *
     * @param mixed $bookmarks entité
     *
     * @return self
     */
    public function setBookmarks($bookmarks): self
    {
        $this->bookmarks = $bookmarks;

        return $this;
    }
}
