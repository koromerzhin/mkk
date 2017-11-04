<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EntityGroup implements Translatable
{
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="group_nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="group_code", unique=true, type="string", length=255)
     */
    protected $code;

    /**
     * @JMS\Exclude
     * @ORM\OneToMany(targetEntity="User", mappedBy="refgroup", cascade={"persist"})
     */
    protected $users;

    /**
     * @var string
     *
     * @ORM\Column(name="group_totalnbuser", type="integer", options={"default": 0})
     */
    protected $totalnbuser;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;

    /**
     * Constructor().
     */
    public function __construct()
    {
        $this->totalnbuser = 0;
        $this->users       = new ArrayCollection();
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
     * Set nom.
     *
     * @param string $nom nom
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
    public function getCode(): string
    {
        return (string) $this->code;
    }

    /**
     * Add users.
     *
     * @param mixed $users entity
     *
     * @return self
     */
    public function addUser($users): self
    {
        $users->setRefGroup($this);
        $this->users->add($users);

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
     * Remove users.
     *
     * @param mixed $users Entity
     *
     * @return self
     */
    public function removeUser($users): self
    {
        $this->users->removeElement($users);

        return $this;
    }

    /**
     * get the value of Totalnbuser.
     *
     * @return int
     */
    public function getTotalnbuser(): int
    {
        return $this->totalnbuser;
    }

    /**
     * Set the value of Totalnbuser.
     *
     * @param int $totalnbuser totalnbuser
     *
     * @return self
     */
    public function setTotalnbuser(int $totalnbuser): self
    {
        $this->totalnbuser = $totalnbuser;

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
}
