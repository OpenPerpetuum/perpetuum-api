<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="accounts", schema="dbo")
 * @ORM\HasLifecycleCallbacks
 */
class Account
{
    const LEVEL_NORMAL = 2;
    const LEAD_SOURCE_API = 'webapiregister';
    const LEAD_SOURCE_GAME = 'opencreate';
    const LEAD_SOURCE_SYNC = 'webapisync';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="accountID", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="password", type="string", nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(name="accLevel", type="integer")
     */
    protected $level = self::LEVEL_NORMAL;

    /**
     * @ORM\Column(name="emailConfirmed", type="boolean")
     */
    protected $hasEmailConfirmed;

    /**
     * @ORM\Column(name="creation", type="datetime", nullable=true)
     */
    protected $createdOn;

    /**
     * @ORM\Column(name="campaignid", type="json_array", nullable=true)
     */
    protected $leadSource;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="account")
     */
    protected $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email = null)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password = null)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setHasEmailConfirmed($hasEmailConfirmed)
    {
        $this->hasEmailConfirmed = $hasEmailConfirmed;
    }

    public function getHasEmailConfirmed()
    {
        return $this->hasConfirmedEmail;
    }

    public function setCreatedOn(DateTime $createdOn = null)
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn(): ?DateTime
    {
        return $this->createdOn;
    }

    public function setLeadSource($leadSource = null)
    {
        $this->leadSource = $leadSource;
    }

    public function getLeadSource()
    {
        return $this->leadSource;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setCreatedOn(new DateTime('now'));
    }
}
