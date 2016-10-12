<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="`user`", uniqueConstraints={
 *     @UniqueConstraint(name="UNIQ_USERNAME", columns={"username"}),
 *     @UniqueConstraint(name="UNIQ_EMAIL", columns={"email"}),
 *     @UniqueConstraint(name="UNIQ_PROFILEPICTURE", columns={"profile_picture_id"})
 * })
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "user" = "User",
 *     "student_parent" = "UserBundle\Entity\StudentParent",
 *     "titular" = "UserBundle\Entity\Titular",
 *     "course_titular" = "UserBundle\Entity\CourseTitular",
 *     "teacher" = "UserBundle\Entity\Teacher",
 *     "coordinator" = "UserBundle\Entity\Coordinator",
 * });
 * @UniqueEntity(
 *     fields={"username"},
 *     message="form.security.username.error.duplicate",
 *     repositoryMethod="findByUniqueCriteria"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="form.security.email.error.duplicate",
 *     repositoryMethod="findByUniqueCriteria"
 * )
 */
class User implements AdvancedUserInterface, \Serializable
{
    use TimestampableEntity;

    const ROLE_STUDENT_PARENT = 'ROLE_STUDENT_PARENT';
    const ROLE_TEACHER = 'ROLE_TEACHER';
    const ROLE_TITULAR = 'ROLE_TITULAR';
    const ROLE_COURSE_TITULAR = 'ROLE_COURSE_TITULAR';
    const ROLE_COORDINATOR = 'ROLE_COORDINATOR';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotNull(message="form.security.first_name.error.missing")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotNull(message="form.security.last_name.error.missing")
     */
    protected $lastName;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotNull(message="form.security.username.error.missing")
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $password;
    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\Email()
     * @Assert\NotNull(message="form.security.email.error.missing")
     */
    protected $email;
    /**
     * @var array
     * @ORM\Column(type="array");
     */
    protected $roles;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isActive;
    /**
     * @var ProfilePicture
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\ProfilePicture", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_picture_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $profilePicture;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    protected $phone;
    /**
     * @var string
     * @Assert\NotBlank(message="form.security.password.error.missing")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @return ProfilePicture|null
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param ProfilePicture|null $profilePicture
     *
     * @return User
     */
    public function setProfilePicture(ProfilePicture $profilePicture = null) : User
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }


    /**
     * String representation of object
     *
     * @link  http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->firstName,
            $this->lastName,
            $this->salt,
            $this->email,
            $this->roles,
            $this->isActive,
        ]);
    }

    /**
     * Constructs the object
     *
     * @link  http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->firstName,
            $this->lastName,
            $this->salt,
            $this->email,
            $this->roles,
            $this->isActive
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPlainPassword(string $password)
    {
        $this->plainPassword = $password;
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
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
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

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     *
     * @return User
     */
    public function setActive(bool $isActive): User
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }
}
