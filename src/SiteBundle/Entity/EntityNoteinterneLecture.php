<?php

namespace Mkk\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityNoteinterneLecture
{
    /**
     * @var int
     *
     * @ORM\Column(name="noteinternelecture_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="noteinternelectures")
     * @ORM\JoinColumn(name="noteinternelecture_refuser", referencedColumnName="user_id")
     */
    protected $refuser;

    /**
     * @ORM\ManyToOne(targetEntity="Noteinterne", inversedBy="noteinternelectures")
     * @ORM\JoinColumn(name="noteinternelecture_refnoteinterne", referencedColumnName="noteinterne_id")
     */
    protected $refnoteinterne;

    /**
     * @var bool
     *
     * @ORM\Column(name="noteinternelecture_lecture", type="boolean", nullable=true)
     */
    protected $lecture;

    /**
     * @var int
     *
     * @ORM\Column(name="noteinternelecture_date", type="integer", nullable=true)
     */
    protected $date;

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
     * Set refuser.
     *
     * @param mixed $refuser Entité user
     *
     * @return self
     */
    public function setRefUser($refuser): self
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
     * Set refnoteinterne.
     *
     * @param mixed $refnoteinterne Entité
     *
     * @return self
     */
    public function setRefNoteinterne($refnoteinterne): self
    {
        $this->refnoteinterne = $refnoteinterne;

        return $this;
    }

    /**
     * get refnoteinterne.
     *
     * @return mixed
     */
    public function getRefNoteinterne()
    {
        return $this->refnoteinterne;
    }

    /**
     * Set lecture.
     *
     * @param bool $lecture lecture
     *
     * @return self
     */
    public function setLecture($lecture): self
    {
        $this->lecture = $lecture;

        return $this;
    }

    /**
     * get lecture.
     *
     * @return bool
     */
    public function isLecture(): bool
    {
        return $this->lecture;
    }

    /**
     * Set date.
     *
     * @param int $date date
     *
     * @return self
     */
    public function setDate(int $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * get datedebut.
     *
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }
}
