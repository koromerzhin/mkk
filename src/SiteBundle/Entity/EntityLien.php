<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

class EntityLien
{
    /**
     * @var int
     *
     * @ORM\Column(name="lien_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lien_adresse", type="text")
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="lien_nom", type="string", nullable=true)
     */
    protected $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="liens")
     * @ORM\JoinColumn(name="lien_refevenement", referencedColumnName="evenement_id", nullable=true, onDelete="CASCADE")
     */
    protected $refevenement;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="liens")
     * @ORM\JoinColumn(name="lien_refuser", referencedColumnName="user_id", nullable=true, onDelete="CASCADE")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="liens")
     * @ORM\JoinColumn(
     *     name="lien_refetablissement",
     *     referencedColumnName="etablissement_id",
     * nullable=true, onDelete="CASCADE")
     */
    protected $refetablissement;

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
     * Set adresse.
     *
     * @param string $adresse url
     *
     * @return self
     */
    public function setAdresse($adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * get adresse.
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
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
    public function getNom(): string
    {
        return (string) $this->nom;
    }

    /**
     * Done le favicon.
     *
     * @return string
     */
    public function getFavicon(): string
    {
        $favicon = 'http://www.google.com/s2/favicons?domain=';
        $adresse = str_replace('http://', '', $this->getAdresse());
        $favicon = "{$favicon}{$adresse}";

        return $favicon;
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
     * @return mixed
     */
    public function getRefEtablissement()
    {
        return $this->refetablissement;
    }

    /**
     * Indique le type du lien.
     *
     * @JMS\VirtualProperty
     *
     * @return string
     */
    public function getType(): string
    {
        $url                = $this->getAdresse();
        $tab                = [];
        $tab['dribble']     = 'dribbble.com';
        $tab['google +']    = 'plus.google.com';
        $tab['youtube']     = ['youtube.com', 'youtu.be'];
        $tab['github']      = 'github.com';
        $tab['bitbucket']   = 'bitbucket.org';
        $tab['twitter']     = 'twitter.com';
        $tab['tripadvisor'] = 'tripadvisor';
        $tab['pinterest']   = 'pinterest.com';
        $tab['facebook']    = 'facebook.com';
        $tab['linkedin']    = 'linkedin.com';
        $tab['instagram']   = 'instagram.com';
        $type               = 'site';
        foreach ($tab as $key => $chaine) {
            if (is_array($chaine)) {
                foreach ($chaine as $code) {
                    if (0 !== substr_count($url, $code)) {
                        $type = $key;
                        break;
                    }
                }
            } else {
                if (0 !== substr_count($url, $chaine)) {
                    $type = $key;
                    break;
                }
            }
        }

        return $type;
    }

    /**
     * Set refevenement.
     *
     * @param mixed $refevenement evenement
     *
     * @return self
     */
    public function setRefEvenement($refevenement = NULL): self
    {
        $this->refevenement = $refevenement;

        return $this;
    }

    /**
     * get refevenement.
     *
     * @return mixed
     */
    public function getRefEvenement()
    {
        return $this->refevenement;
    }
}
