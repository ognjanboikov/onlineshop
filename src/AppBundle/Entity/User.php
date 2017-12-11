<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use AppBundle\Controller\SecurityController;
use AppBundle\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository;


/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, unique=true)
     */
    private $userName;
    /**
     * @var string
     */
    private $plainPassword;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;
    /**
     * @var decimal
     *
     * @ORM\Column(name="cash", type="decimal", precision=10, scale=2)
     */
    private $cash;

    /**
     * @var decimal
     *
     * @ORM\Column(name="usedCash", type="decimal", precision=10, scale=2)
     */
    private $usedCash;

    /**
     * @var datetime
     *
     * @ORM\Column(name="registerDate", type="datetime")
     */
    private $registerDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isBanned", type="boolean", nullable=true)
     */
    private $isBanned;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinTable(name="user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     * @var Collection|Role[]
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles as $role){
            $roles[] = $role->getName();
        }
        return $roles;
        return $this->roles;
    }

    public function setRoles($role){
        $this->roles = $role;
        return $this;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getUserName(),
            $this->getPassword()
        ]);
    }
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->userName,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword.'';
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    /**
     * @return decimal
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param decimal $cash
     */
    public function setCash($cash)
    {
        $this->cash = $cash;
    }
    /**
     * @return decimal
     */
    public function getUsedCash()
    {
        return $this->usedCash;
    }

    /**
     * @param decimal $usedCash
     */
    public function setUsedCash($usedCash)
    {
        $this->usedCash = $usedCash;
    }

    /**
     * @return datetime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @param datetime $registerDate
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    }

    /**
     * @return mixed
     */
    public function getisBanned()
    {
        return $this->isBanned;
    }

    /**
     * @param mixed $isBanned
     */
    public function setIsBanned($isBanned)
    {
        $this->isBanned = $isBanned;
    }

}

