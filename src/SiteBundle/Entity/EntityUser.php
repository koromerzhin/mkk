<?php

namespace Mkk\SiteBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Mkk\SiteBundle\Annotation\UploadableField;

class EntityUser implements UserInterface
{
    const COUNTDATA13 = 13;
    const COUNTDATA11 = 11;
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_temporaire", type="boolean", nullable=true)
     */
    protected $temporaire;

    /**
     * @var string
     *
     * @ORM\Column(name="user_avatar", type="text", nullable=true)
     */
    protected $avatar;

    /**
     * @UploadableField(filename="avatar", path="user/avatar", unique=true, alias="username")
     */
    protected $fileAvatar;

    /**
     * @var string
     *
     * @ORM\Column(name="user_naissance", type="text", nullable=true)
     */
    protected $naissance;

    /**
     * @var string
     *
     * @ORM\Column(name="user_contactsms", type="boolean", nullable=true)
     */
    protected $contactsms;

    /**
     * @var string
     *
     * @ORM\Column(name="user_contactadresse", type="boolean", nullable=true)
     */
    protected $contactadresse;

    /**
     * @var string
     *
     * @ORM\Column(name="user_contactemail", type="boolean", nullable=true)
     */
    protected $contactemail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_nom", type="string", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_civilite", type="string", nullable=true)
     */
    protected $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="user_type", type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="user_langue", type="string", nullable=true)
     */
    protected $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pays", type="string", nullable=true)
     */
    protected $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="user_prenom", type="string", nullable=true)
     */
    protected $prenom;

    /**
     * @var string
     * @JMS\Exclude
     * @ORM\Column(name="user_password", type="string", nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(name="user_salt", type="string", length=255)
     * @JMS\Exclude
     *
     * @var string salt
     */
    protected $salt;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="users")
     * @ORM\JoinColumn(name="user_refgroup", referencedColumnName="group_id")
     * @JMS\Exclude
     */
    protected $refgroup;

    /**
     * @ORM\ManyToMany(targetEntity="Etablissement",  mappedBy="users")
     */
    protected $etablissements;

    /**
     * @var bool
     *
     * @ORM\Column(name="user_active", type="boolean")
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="user_username", type="text", nullable=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="user_username_canonical", type="text", nullable=true)
     */
    protected $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="text", nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email_canonical", type="text", nullable=true)
     */
    protected $emailCanonical;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="user_dateinscription", type="datetime", nullable=true)
     */
    protected $dateinscription;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="user_last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var bool
     *
     * @ORM\Column(name="user_newsletter", type="boolean", nullable=true)
     */
    protected $newsletter;

    /**
     * @var string
     *
     * @ORM\Column(name="user_observations", type="text", nullable=true)
     */
    protected $observations;

    /**
     * @var array
     *
     * @ORM\Column(name="user_data", type="array", nullable=true)
     */
    protected $data;

    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="refuser", cascade={"all"})
     */
    protected $adresses;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="refuser", cascade={"all"})
     */
    protected $emails;

    /**
     * @ORM\OneToMany(targetEntity="Lien", mappedBy="refuser", cascade={"all"})
     */
    protected $liens;

    /**
     * @ORM\OneToMany(targetEntity="Telephone", mappedBy="refuser", cascade={"all"})
     */
    protected $telephones;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="refuser", cascade={"all"})
     */
    protected $evenements;

    /**
     * @ORM\OneToMany(targetEntity="Noteinterne", mappedBy="refuser", cascade={"remove", "persist"})
     */
    protected $noteinternes;

    /**
     * @ORM\OneToMany(targetEntity="NoteinterneLecture", mappedBy="refuser", cascade={"remove", "persist"})
     */
    protected $noteinternelectures;

    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="refuser", cascade={"remove", "persist"})
     */
    protected $blogs;

    /**
     * @ORM\OneToMany(targetEntity="Edito", mappedBy="refuser", cascade={"remove", "persist"})
     */
    protected $editos;

    /**
     * @var string
     *
     * @ORM\Column(name="user_tags", type="string", nullable=true)
     */
    protected $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="user_douanier", type="string", nullable=true)
     */
    protected $douanier;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     *
     * @ORM\Column(name="user_plain_password", type="string", nullable=true)
     */
    protected $plainPassword;

    /**
     * Random string sent to the user email address in order to verify it.
     *
     * @var string
     *
     * @ORM\Column(name="user_confirmation_token", type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="user_password_request_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @var Collection
     */
    protected $groups;

    /**
     * @var array
     *
     * @ORM\Column(name="user_roles", type="array", nullable=true)
     */
    protected $roles;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Init.
     */
    public function __construct()
    {
        $this->enabled        = TRUE;
        $this->roles          = ['ROLE_ADMIN'];
        $this->salt           = md5(uniqid(NULL, TRUE));
        $this->liens          = new ArrayCollection();
        $this->emails         = new ArrayCollection();
        $this->telephones     = new ArrayCollection();
        $this->etablissements = new ArrayCollection();
    }

    /**
     * Permet de transformer l'entité en string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $return = (string) "{$this->getNom()} {$this->getPrenom()}";

        return $return;
    }

    /**
     * serialize (UserInterface).
     *
     * @return mixed
     */
    public function serialize()
    {
        $return = serialize(
            [
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->enabled,
            $this->id,
            $this->email,
            $this->emailCanonical,
            ]
        );

        return $return;
    }

    /**
     * Unserialize (UserInterface).
     *
     * @param string $serialized serialised string
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);

        if (self::COUNTDATA13 === count($data)) {
            // Unserializing a User object from 1.3.x
            unset($data[4], $data[5], $data[6], $data[9], $data[10]);
            $data = array_values($data);
        } elseif (self::COUNTDATA11 === count($data)) {
            // Unserializing a User from a dev version somewhere between 2.0-alpha3 and 2.0-beta1
            unset($data[4], $data[7], $data[8]);
            $data = array_values($data);
        }

        list(
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->enabled,
            $this->id,
            $this->email,
            $this->emailCanonical
        ) = $data;
    }

    /**
     * Ajoute un role.
     *
     * @param string $role nom du role
     *
     * @return self
     */
    public function addRole($role): self
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * gets an array of roles.
     *
     * @return array An array of Role objects
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        $return = array_unique($roles);

        return $return;
    }

    /**
     * Le compte est non expiré.
     *
     * @return bool
     */
    public function isAccountNonExpired(): bool
    {
        return TRUE;
    }

    /**
     * Le compte est non expiré.
     *
     * @return bool
     */
    public function isCredentialsNonExpired(): bool
    {
        return TRUE;
    }

    /**
     * Le compte est désactivé.
     *
     * @return bool
     */
    public function isAccountNonLocked(): bool
    {
        return TRUE;
    }

    /**
     * Il a le role ?
     *
     * @param string $role nom du role
     *
     * @return bool
     */
    public function hasRole($role): bool
    {
        $return = in_array(strtoupper($role), $this->getRoles());

        return $return;
    }

    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param UserInterface $user The user
     *
     * @return bool True if equal, false othwerwise
     */
    public function equals(UserInterface $user)
    {
        $return = md5($this->getUsername()) === md5($user->getUsername());

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
     * gets the user password.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Affiche le plainPassword.
     *
     * @return string
     */
    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    /**
     * Last Login.
     *
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Token.
     *
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return (string) $this->confirmationToken;
    }

    /**
     * Sets the user password.
     *
     * @param string $value The password
     *
     * @return self
     */
    public function setPassword($value): self
    {
        $this->password = $value;

        return $this;
    }

    /**
     * Get email Canonical.
     *
     * @return string
     */
    public function getEmailCanonical(): string
    {
        return (string) $this->emailCanonical;
    }

    /**
     * Donne le role Super_admin.
     *
     * @param bool $boolean bool
     *
     * @return self
     */
    public function setSuperAdmin($boolean): self
    {
        if (TRUE === $boolean) {
            $this->addRole(static::ROLE_SUPER_ADMIN);
        } else {
            $this->removeRole(static::ROLE_SUPER_ADMIN);
        }

        return $this;
    }

    /**
     * Pour générer un nouveau mot de passe.
     *
     * @param string $password password
     *
     * @return self
     */
    public function setPlainPassword($password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * Enregistre la date quand l'utilisateur s'est connecté.
     *
     * @param DateTime $time temps
     *
     * @return self
     */
    public function setLastLogin(DateTime $time = NULL): self
    {
        $this->lastLogin = $time;

        return $this;
    }

    /**
     * Change le token.
     *
     * @param string $confirmationToken token
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Ajoute des roles (UserInterface).
     *
     * @param array $roles Liste des roles
     *
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * Verifie si le mot de passe est expiré (UserInterface).
     *
     * @param mixed $ttl Surement un int
     *
     * @return bool
     */
    public function isPasswordRequestNonExpired($ttl): bool
    {
        $return = $this->getPasswordRequestedAt() instanceof DateTime && $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();

        return $return;
    }

    /**
     * Gets the timestamp that the user requested a password reset.
     *
     * @return mixed
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Dire quand le mot de passe a été changé.
     *
     * @param DateTime $date date
     *
     * @return self
     */
    public function setPasswordRequestedAt(DateTime $date = NULL): self
    {
        $this->passwordRequestedAt = $date;

        return $this;
    }

    /**
     * gets the user salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the user salt.
     *
     * @param string $value The salt
     *
     * @return self
     */
    public function setSalt($value): self
    {
        $this->salt = $value;

        return $this;
    }

    /**
     * gets the username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $value The username
     *
     * @return self
     */
    public function setUsername($value): self
    {
        $this->username = $value;

        return $this;
    }

    /**
     * (UserInterface).
     *
     * @param mixed $usernameCanonical Username Canonical
     *
     * @return self
     */
    public function setUsernameCanonical($usernameCanonical): self
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * get nom.
     *
     * @return string
     */
    public function getNom(): string
    {
        $return = mb_strtoupper($this->nom, 'UTF-8');

        return (string) $return;
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
        $this->nom = mb_strtoupper($nom, 'UTF-8');

        return $this;
    }

    /**
     * get prenom.
     *
     * @return string
     */
    public function getPrenom(): string
    {
        $return = ucfirst(mb_strtolower($this->prenom, 'UTF-8'));

        return $return;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom prénom
     *
     * @return self
     */
    public function setPrenom($prenom): self
    {
        $this->prenom = ucfirst(mb_strtolower($prenom, 'UTF-8'));

        return $this;
    }

    /**
     * Set refgroup.
     *
     * @param mixed $refgroup group de l'utilisateur
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
     * @return mixed
     */
    public function getRefGroup()
    {
        return $this->refgroup;
    }

    /**
     * Erases the user credentials.
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = NULL;
    }

    /**
     * Set active.
     *
     * @param bool $enabled active / desactive l'utilisateur
     *
     * @return self
     */
    public function setEnabled($enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * get active.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * L'utilisateur est un super-admin ??? (UserInterface).
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        $return = $this->hasRole(static::ROLE_SUPER_ADMIN);

        return $return;
    }

    /**
     * Supprimer Role (UserInterface).
     *
     * @param mixed $role Role à supprimer
     *
     * @return self
     */
    public function removeRole($role): self
    {
        unset($role);

        return $this;
    }

    /**
     * Set email.
     *
     * @param string $email email principal
     *
     * @return self
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * set emailCanonical (UserInterface).
     *
     * @param string $emailCanonical email canonical
     *
     * @return self
     */
    public function setEmailCanonical($emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return (string) $this->email;
    }

    /**
     * Set dateinscription.
     *
     * @param DateTime $dateinscription date d'inscription
     *
     * @return self
     */
    public function setDateinscription(DateTime $dateinscription = NULL): self
    {
        $this->dateinscription = $dateinscription;

        return $this;
    }

    /**
     * get dateinscription.
     *
     * @return mixed
     */
    public function getDateinscription()
    {
        return $this->dateinscription;
    }

    /**
     * Set civilite.
     *
     * @param string $civilite civilité
     *
     * @return self
     */
    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * get civilite.
     *
     * @return string
     */
    public function getCivilite(): string
    {
        return (string) $this->civilite;
    }

    /**
     * Set observations.
     *
     * @param string $observations observations
     *
     * @return self
     */
    public function setObservations(string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * get observations.
     *
     * @return string
     */
    public function getObservations(): string
    {
        return (string) $this->observations;
    }

    /**
     * Add adresses.
     *
     * @param mixed $adresses entity
     *
     * @return self
     */
    public function addAdresse($adresses): self
    {
        $adresses->setRefUser($this);
        $this->adresses->add($adresses);

        return $this;
    }

    /**
     * Remove adresses.
     *
     * @param mixed $adresses Entity
     *
     * @return self
     */
    public function removeAdresse($adresses): self
    {
        $this->adresses->removeElement($adresses);

        return $this;
    }

    /**
     * get adresses.
     *
     * @return mixed
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set langue.
     *
     * @param string $langue langue parlé principal
     *
     * @return self
     */
    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * get langue.
     *
     * @return string
     */
    public function getLangue(): string
    {
        return (string) $this->langue;
    }

    /**
     * Set pays.
     *
     * @param string $pays code du pays
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
     * Add telephones.
     *
     * @param mixed $telephones entity
     *
     * @return self
     */
    public function addTelephone($telephones): self
    {
        $telephones->setRefUser($this);
        $this->telephones->add($telephones);

        return $this;
    }

    /**
     * Remove telephones.
     *
     * @param mixed $telephones Entity
     *
     * @return self
     */
    public function removeTelephone($telephones): self
    {
        $this->telephones->removeElement($telephones);

        return $this;
    }

    /**
     * get telephones.
     *
     * @return mixed
     */
    public function getTelephones()
    {
        return $this->telephones;
    }

    /**
     * Set contactsms.
     *
     * @param bool $contactsms bool
     *
     * @return self
     */
    public function setContactsms(bool $contactsms): self
    {
        $this->contactsms = $contactsms;

        return $this;
    }

    /**
     * get contactsms.
     *
     * @return bool
     */
    public function isContactsms(): bool
    {
        return (bool) $this->contactsms;
    }

    /**
     * Set contactemail.
     *
     * @param bool $contactemail bool
     *
     * @return self
     */
    public function setContactemail(bool $contactemail): self
    {
        $this->contactemail = $contactemail;

        return $this;
    }

    /**
     * get contactemail.
     *
     * @return bool
     */
    public function isContactemail(): bool
    {
        return (bool) $this->contactemail;
    }

    /**
     * NE PAS UTILISER.
     *
     * @param string $data data
     *
     * @return self
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * get data.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set newsletter.
     *
     * @param bool $newsletter bool
     *
     * @return self
     */
    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * get newsletter.
     *
     * @return bool
     */
    public function isNewsletter(): bool
    {
        return (bool) $this->newsletter;
    }

    /**
     * Add emails.
     *
     * @param mixed $emails entity
     *
     * @return self
     */
    public function addEmail($emails): self
    {
        $emails->setRefUser($this);
        $this->emails->add($emails);

        return $this;
    }

    /**
     * Remove emails.
     *
     * @param mixed $emails Entity
     *
     * @return self
     */
    public function removeEmail($emails): self
    {
        $this->emails->removeElement($emails);

        return $this;
    }

    /**
     * get emails.
     *
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add liens.
     *
     * @param mixed $liens entity
     *
     * @return self
     */
    public function addLien($liens): self
    {
        $liens->setRefUser($this);
        $this->liens->add($liens);

        return $this;
    }

    /**
     * get liens.
     *
     * @return mixed
     */
    public function getLiens()
    {
        return $this->liens;
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
     * Set avatar.
     *
     * @param string $avatar avatar
     *
     * @return self
     */
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * get avatar.
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return (string) $this->avatar;
    }

    /**
     * Set naissance.
     *
     * @param string $naissance date de naissance
     *
     * @return self
     */
    public function setNaissance($naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * get naissance.
     *
     * @return string
     */
    public function getNaissance()
    {
        return $this->naissance;
    }

    /**
     * Remove liens.
     *
     * @param mixed $liens Entity
     *
     * @return self
     */
    public function removeLien($liens): self
    {
        $this->liens->removeElement($liens);

        return $this;
    }

    /**
     * Set contactadresse.
     *
     * @param bool $contactadresse Bool
     *
     * @return self
     */
    public function setContactadresse(bool $contactadresse): self
    {
        $this->contactadresse = $contactadresse;

        return $this;
    }

    /**
     * get contactadresse.
     *
     * @return bool
     */
    public function isContactadresse(): bool
    {
        return (bool) $this->contactadresse;
    }

    /**
     * Add etablissements.
     *
     * @param mixed $etablissement entity
     *
     * @return self
     */
    public function addEtablissement($etablissement): self
    {
        $this->etablissements->add($etablissement);

        return $this;
    }

    /**
     * Remove etablissements.
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
     * Set temporaire.
     *
     * @param bool $temporaire temporaire
     *
     * @return self
     */
    public function setTemporaire(bool $temporaire): self
    {
        $this->temporaire = $temporaire;

        return $this;
    }

    /**
     * get temporaire.
     *
     * @return bool
     */
    public function isTemporaire(): bool
    {
        return (bool) $this->temporaire;
    }

    /**
     * Add noteinternes.
     *
     * @param mixed $noteinternes entity
     *
     * @return self
     */
    public function addNoteinternes($noteinternes): self
    {
        $noteinternes->setRefUser($this);
        $this->noteinternes[] = $noteinternes;

        return $this;
    }

    /**
     * Remove noteinternes.
     *
     * @param mixed $noteinternes Entity
     *
     * @return self
     */
    public function removeNoteinternes($noteinternes): self
    {
        $this->noteinternelectures->removeElement($noteinternes);

        return $this;
    }

    /**
     * get noteinternes.
     *
     * @return mixed
     */
    public function getNoteinternes()
    {
        return $this->noteinternes;
    }

    /**
     * Add noteinternelectures.
     *
     * @param mixed $noteinternelectures entity
     *
     * @return self
     */
    public function addNoteinterneLectures($noteinternelectures): self
    {
        $noteinternelectures->setRefUser($this);
        $this->noteinternelectures[] = $noteinternelectures;

        return $this;
    }

    /**
     * Remove noteinternelectures.
     *
     * @param mixed $noteinternelectures Entity
     *
     * @return self
     */
    public function removeNoteinterneLectures($noteinternelectures): self
    {
        $this->noteinternelectures->removeElement($noteinternelectures);

        return $this;
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
        $blogs->setRefUser($this);
        $this->blogs[] = $blogs;

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
     * Add editos.
     *
     * @param mixed $editos entity
     *
     * @return self
     */
    public function addEdito($editos): self
    {
        $editos->setRefUser($this);
        $this->editos[] = $editos;

        return $this;
    }

    /**
     * Remove edito.
     *
     * @param mixed $editos Entity
     *
     * @return self
     */
    public function removeEdito($editos): self
    {
        $this->editos->removeElement($editos);

        return $this;
    }

    /**
     * get editos.
     *
     * @return mixed
     */
    public function getEditos()
    {
        return $this->editos;
    }

    /**
     * Set tags.
     *
     * @param string $tags tags
     *
     * @return self
     */
    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * get tags.
     *
     * @return string
     */
    public function getTags(): string
    {
        return (string) $this->tags;
    }

    /**
     * Set douanier.
     *
     * @param string $douanier douanier
     *
     * @return self
     */
    public function setDouanier(string $douanier): self
    {
        $this->douanier = $douanier;

        return $this;
    }

    /**
     * get douanier.
     *
     * @return string
     */
    public function getDouanier(): string
    {
        return (string) $this->douanier;
    }

    /**
     * Set the value of Etablissements.
     *
     * @param mixed $etablissements etablissements
     *
     * @return self
     */
    public function setEtablissements($etablissements): self
    {
        $this->etablissements = $etablissements;

        return $this;
    }

    /**
     * Set the value of Adresses.
     *
     * @param mixed $adresses adresses
     *
     * @return self
     */
    public function setAdresses($adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }

    /**
     * Set the value of Emails.
     *
     * @param mixed $emails emails
     *
     * @return self
     */
    public function setEmails($emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Set the value of Liens.
     *
     * @param mixed $liens liens
     *
     * @return self
     */
    public function setLiens($liens): self
    {
        $this->liens = $liens;

        return $this;
    }

    /**
     * Set the value of Telephones.
     *
     * @param mixed $telephones telephones
     *
     * @return self
     */
    public function setTelephones($telephones): self
    {
        $this->telephones = $telephones;

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
     * Set the value of Noteinternes.
     *
     * @param mixed $noteinternes noteinternes
     *
     * @return self
     */
    public function setNoteinternes($noteinternes): self
    {
        $this->noteinternes = $noteinternes;

        return $this;
    }

    /**
     * get the value of Noteinternelectures.
     *
     * @return mixed
     */
    public function getNoteinternelectures()
    {
        return $this->noteinternelectures;
    }

    /**
     * Set the value of Noteinternelectures.
     *
     * @param mixed $noteinternelectures noteinternelectures
     *
     * @return self
     */
    public function setNoteinternelectures($noteinternelectures): self
    {
        $this->noteinternelectures = $noteinternelectures;

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
     * Set the value of Editos.
     *
     * @param mixed $editos editos
     *
     * @return self
     */
    public function setEditos($editos): self
    {
        $this->editos = $editos;

        return $this;
    }

    /**
     * Donne le nom canonical.
     *
     * @return string
     */
    public function getUsernameCanonical(): string
    {
        return (string) $this->usernameCanonical;
    }

    /**
     * Récupére la liste des groups.
     *
     * @return mixed
     */
    public function getGroups()
    {
        $return = $this->groups ?: $this->groups = new ArrayCollection();

        return $return;
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
            'nom' => $this->__toString(),
        ];

        return $tab;
    }

    /**
     * Retour pour selec2.
     *
     * @return mixed
     */
    public function getGroup()
    {
        $return = !is_object($this->getRefGroup()) ? '' : $this->getRefGroup()->getId();

        return $return;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setGroup($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Retour pour select2.
     *
     * @return string
     */
    public function getTabEtablissements(): string
    {
        $tab = [];
        if (0 !== count($this->getEtablissements())) {
            foreach ($this->getEtablissements() as $produit) {
                if ($produit) {
                    $tab[] = $produit->getId();
                }
            }
        }

        $retour = implode(',', $tab);

        return $retour;
    }

    /**
     * Champs créer pour select2.
     *
     * @param mixed $valNull Champs qui ne sert à rien mais qu'il faut remplir
     *
     * @return self
     */
    public function setTabEtablissements($valNull): self
    {
        unset($valNull);

        return $this;
    }

    /**
     * Get the value of Description of what this does.
     *
     * @return string
     */
    public function getFileAvatar(): string
    {
        return (string) $this->fileAvatar;
    }

    /**
     * Set the value of Description of what this does.
     *
     * @param string $fileAvatar code MD5
     *
     * @return self
     */
    public function setFileAvatar(string $fileAvatar): self
    {
        $this->fileAvatar = $fileAvatar;

        return $this;
    }

    /**
     * Get the value of Updated At.
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At.
     *
     * @param DateTime $updatedAt date
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
