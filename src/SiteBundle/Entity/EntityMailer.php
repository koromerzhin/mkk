<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

class EntityMailer
{
    /**
     * @var int
     *
     * @ORM\Column(name="mailer_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer_subject", type="string", length=255)
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer_from", type="string", length=255)
     */
    protected $from;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer_reply", type="string", nullable=true)
     */
    protected $reply;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer_to", type="string", length=255)
     */
    protected $to;

    /**
     * @var array
     *
     * @ORM\Column(name="mailer_cc", type="array", length=255, nullable=true)
     */
    protected $cc;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer_body", type="text", nullable=true)
     */
    protected $body;

    /**
     * @var array
     *
     * @ORM\Column(name="mailer_fichiers", type="array", length=255, nullable=true)
     */
    protected $fichiers;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="mailer_date_enregistrement", type="datetime", length=255, nullable=true)
     */
    protected $dateEnregistrement;

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
     * Get the value of Subject.
     *
     * @return string
     */
    public function getSubject(): string
    {
        return (string) $this->subject;
    }

    /**
     * Set the value of Subject.mixed.
     *
     * @param string $subject sujet
     *
     * @return self
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of From.
     *
     * @return string
     */
    public function getFrom(): string
    {
        return (string) $this->from;
    }

    /**
     * Set the value of From.
     *
     * @param string $from from
     *
     * @return self
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the value of To.
     *
     * @return string
     */
    public function getTo(): string
    {
        return (string) $this->to;
    }

    /**
     * Set the value of To.
     *
     * @param string $to to
     *
     * @return self
     */
    public function setTo(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get the value of Body.
     *
     * @return string
     */
    public function getBody(): string
    {
        return (string) $this->body;
    }

    /**
     * Set the value of Body.
     *
     * @param string $body corps du mail
     *
     * @return self
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of Fichiers.
     *
     * @return array
     */
    public function getFichiers(): array
    {
        return (array) $this->fichiers;
    }

    /**
     * Set the value of Fichiers.
     *
     * @param array $fichiers fichiers
     *
     * @return self
     */
    public function setFichiers(array $fichiers): self
    {
        $this->fichiers = $fichiers;

        return $this;
    }

    /**
     * Get the value of Date Enregistrement.
     *
     * @return mixed
     */
    public function getDateEnregistrement()
    {
        return $this->dateEnregistrement;
    }

    /**
     * Set the value of Date Enregistrement.
     *
     * @param DateTime $dateEnregistrement date
     *
     * @return self
     */
    public function setDateEnregistrement(DateTime $dateEnregistrement): self
    {
        $this->dateEnregistrement = $dateEnregistrement;

        return $this;
    }

    /**
     * Get the value of Reply.
     *
     * @return string
     */
    public function getReply(): string
    {
        return (string) $this->reply;
    }

    /**
     * Set the value of Reply.
     *
     * @param string $reply reply
     *
     * @return self
     */
    public function setReply(string $reply): self
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get the value of Cc.
     *
     * @return array
     */
    public function getCc(): array
    {
        return (array) $this->cc;
    }

    /**
     * Set the value of Cc.
     *
     * @param array $cc cc
     *
     * @return self
     */
    public function setCc(array $cc): self
    {
        $this->cc = $cc;

        return $this;
    }
}
