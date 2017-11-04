<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

class EntityAction
{
    /**
     * @var int
     *
     * @ORM\Column(name="action_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="actions")
     * @ORM\JoinColumn(name="action_refgroup", referencedColumnName="group_id")
     * @JMS\Exclude
     */
    protected $refgroup;

    /**
     * @var bool
     *
     * @ORM\Column(name="action_etat", type="boolean", nullable=true)
     */
    protected $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="action_route", type="string", nullable=true)
     */
    protected $route;

    /**
     * Get the value of Id.
     *
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * Get the value of Refgroup.
     *
     * @return mixed
     */
    public function getRefgroup()
    {
        return $this->refgroup;
    }

    /**
     * Set the value of Refgroup.
     *
     * @param mixed $refgroup refgroup
     *
     * @return self
     */
    public function setRefgroup($refgroup)
    {
        $this->refgroup = $refgroup;

        return $this;
    }

    /**
     * Get the value of Etat.
     *
     * @return bool
     */
    public function isEtat(): bool
    {
        return $this->etat;
    }

    /**
     * Set the value of Etat.
     *
     * @param bool $etat etat
     *
     * @return self
     */
    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of Route.
     *
     * @return string
     */
    public function getRoute(): string
    {
        return (string) $this->route;
    }

    /**
     * Set the value of Route.
     *
     * @param string $route route
     *
     * @return self
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }
}
