<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class EntityNafSousClasse implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="nafsousclasse_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nafsousclasse_code", type="string", length=255)
     */
    protected $code;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="nafsousclasse_libelle", type="string", length=255)
     */
    protected $libelle;

    /**
     * @ORM\OneToMany(targetEntity="Etablissement", mappedBy="refnafsousclasse", cascade={"remove", "persist"})
     * @ORM\OrderBy({"position": "ASC", "nom": "ASC"})
     */
    protected $etablissements; /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getCode() . ' ' . $this->getLibelle();

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
     * Get the value of Code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return (string) $this->code;
    }

    /**
     * Set the value of Code.
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
     * Get the value of Libelle.
     *
     * @return string
     */
    public function getLibelle(): string
    {
        return (string) $this->libelle;
    }

    /**
     * Set the value of Libelle.
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
     * Add etablissement.
     *
     * @param mixed $etablissement entity
     *
     * @return self
     */
    public function addEtablissement($etablissement): self
    {
        $etablissement->setRefNafSousClasse($this);
        $this->etablissements->add($etablissement);

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
     * Fonction pour les resultats de select2.
     *
     * @return array
     */
    public function getSearchData(): array
    {
        $tab = [
            'id'  => $this->getId(),
            'nom' => $this->getCode() . ' ' . $this->getLibelle(),
        ];

        return $tab;
    }
}
