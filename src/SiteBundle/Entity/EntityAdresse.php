<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

class EntityAdresse
{
    /**
     * @var int
     *
     * @ORM\Column(name="adresse_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="adresse_pmr", type="boolean", nullable=true)
     */
    protected $pmr;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_info", type="string", nullable=true)
     */
    protected $info;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_pays", type="string", nullable=true)
     */
    protected $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_cp", type="string", nullable=true)
     */
    protected $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_ville", type="string", nullable=true)
     */
    protected $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_gps", type="string", nullable=true)
     */
    protected $gps;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_gps_lat", type="string", nullable=true)
     */
    protected $gpsLat;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_gps_lon", type="string", nullable=true)
     */
    protected $gpsLon;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="adresses")
     * @ORM\JoinColumn(name="adresse_refuser", referencedColumnName="user_id", nullable=true, onDelete="CASCADE")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="adresses")
     * @ORM\JoinColumn(
     *     name="adresse_refetablissement",
     *     referencedColumnName="etablissement_id",
     *     nullable=true,
     *     onDelete="CASCADE"
     * )
     */
    protected $refetablissement;

    /**
     * @ORM\ManyToOne(targetEntity="Emplacement", inversedBy="adresses")
     * @ORM\JoinColumn(
     *     name="adresse_refemplacement",
     *     referencedColumnName="emplacement_id",
     *     nullable=true,
     *     onDelete="CASCADE"
     * )
     */
    protected $refemplacement;

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) $this->getVille();

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
     * Set info.
     *
     * @param string $info info
     *
     * @return self
     */
    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    /**
     * get info.
     *
     * @return string
     */
    public function getInfo(): string
    {
        $tab  = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5);
        $info = strip_tags($this->info);
        foreach ($tab as $code => $val) {
            $info = str_replace($val, $code, $info);
        }

        return (string) $info;
    }

    /**
     * Set pays.
     *
     * @param string $pays pays
     *
     * @return self
     */
    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * get pays.
     *
     * @return string
     */
    public function getPays(): string
    {
        return (string) $this->pays;
    }

    /**
     * Set cp.
     *
     * @param string $cp cp
     *
     * @return self
     */
    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * get cp.
     *
     * @return string
     */
    public function getCp(): string
    {
        return (string) $this->cp;
    }

    /**
     * Set ville.
     *
     * @param string $ville ville
     *
     * @return self
     */
    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * get ville.
     *
     * @return string
     */
    public function getVille(): string
    {
        $return = mb_strtoupper($this->ville, 'UTF-8');

        return (string) $return;
    }

    /**
     * Set gps_lat.
     *
     * @param string $gpsLat gpsLat
     *
     * @return self
     */
    public function setGpsLat(string $gpsLat): self
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    /**
     * get gps_lat.
     *
     * @return string
     */
    public function getGpsLat(): string
    {
        return (string) $this->gpsLat;
    }

    /**
     * Set gps_lon.
     *
     * @param string $gpsLon gpsLon
     *
     * @return self
     */
    public function setGpsLon(string $gpsLon): self
    {
        $this->gpsLon = $gpsLon;

        return $this;
    }

    /**
     * get gps_lon.
     *
     * @return string
     */
    public function getGpsLon(): string
    {
        return (string) $this->gpsLon;
    }

    /**
     * Set gps.
     *
     * @param string $gps gps
     *
     * @return self
     */
    public function setGps(string $gps): self
    {
        if ('' !== $gps) {
            list($lat, $lon) = explode(',', $gps);
        } else {
            $lat = '';
            $lon = '';
        }

        $this->setGpsLat($lat);
        $this->setGpsLon($lon);
        $this->gps = $gps;

        return $this;
    }

    /**
     * get gps.
     *
     * @return string
     */
    public function getGps(): string
    {
        return (string) $this->gps;
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
     * Set refuser.
     *
     * @param mixed $refuser refuser
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
     * @param mixed $refetablissement refetablissement
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
     * Set refemplacement.
     *
     * @param mixed $refemplacement refemplacement
     *
     * @return self
     */
    public function setRefEmplacement($refemplacement = NULL): self
    {
        $this->refemplacement = $refemplacement;

        return $this;
    }

    /**
     * get refemplacement.
     *
     * @return mixed
     */
    public function getRefEmplacement()
    {
        return $this->refemplacement;
    }

    /**
     * Set pmr.
     *
     * @param string $pmr pmr
     *
     * @return self
     */
    public function setPmr(bool $pmr): self
    {
        $this->pmr = $pmr;

        return $this;
    }

    /**
     * get pmr.
     *
     * @return string
     */
    public function isPmr(): bool
    {
        return $this->pmr;
    }

    /**
     * @return string
     *                WIP
     * @JMS\VirtualProperty
     */
    public function getGoogleUrl()
    {
        $url  = '';
        $url  = 'https://maps.google.com/?q=';
        $info = $this->getInfo();
        if (0 !== substr_count($info, "\n")) {
            $info = explode("\n", $info);
            $info = $info[0];
        }

        $url = $url . urlencode($info);
        $url = $url . '+' . $this->getCp();
        $url = $url . '+' . urlencode($this->getVille());
        $url = $url . '&ll=' . $this->getGps();

        return $url;
    }
}
