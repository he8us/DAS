<?php

namespace UserBundle\Entity;

use CourseBundle\Entity\GradeClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use UserBundle\Repository\StudentRepository;

/**
 * Student
 * @ORM\Table(name="student", uniqueConstraints={
 *     @UniqueConstraint(name="UNIQ_USERNAME", columns={"username"}),
 *     @UniqueConstraint(name="UNIQ_EMAIL", columns={"email"}),
 *     @UniqueConstraint(name="UNIQ_PROFILEPICTURE", columns={"profile_picture_id"})
 * })
 * @ORM\Entity(repositoryClass="UserBundle\Repository\StudentRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="user.student.username.error.duplicate",
 *     repositoryMethod="findByUniqueCriteria",
 *     groups={"edition", "creation"}
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="user.student.email.error.duplicate",
 *     repositoryMethod="findByUniqueCriteria",
 *     groups={"edition", "creation"}
 * )
 */
class Student implements AdvancedUserInterface, \Serializable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    const ROLE_STUDENT = 'ROLE_STUDENT';

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
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @var ProfilePicture
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\ProfilePicture", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_picture_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $profilePicture;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     * @Gedmo\Slug(fields={"firstName", "lastName"}, separator="_", unique=true, unique_base="username")
     * @ORM\Column(type="string", length=101, unique=true)
     */
    private $username;

    /**
     * @var GradeClass
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\GradeClass", inversedBy="students")
     * @ORM\JoinColumn(name="grade_class_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $gradeClass;

    /**
     * @var string
     * @ORM\Column(name="barcode", type="string", length=20, unique=true)
     */
    private $barcode;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\StudentParent", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parents;

    /**
     * @var array
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Lesson", mappedBy="students")
     */
    private $lessons;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->roles = ['ROLE_STUDENT'];
        $this->isActive = true;
        $this->lessons = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Student
     */
    public function setId(int $id): Student
    {
        $this->id = $id;
        return $this;
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
     * @return Student
     */
    public function setProfilePicture(ProfilePicture $profilePicture = null): Student
    {
        $this->profilePicture = $profilePicture;
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
     * @param string $username
     *
     * @return Student
     */
    public function setUsername(string $username): Student
    {
        $this->username = $username;
        return $this;
    }


    /**
     * @return GradeClass
     */
    public function getGradeClass()
    {
        return $this->gradeClass;
    }

    /**
     * @param GradeClass $gradeClass
     *
     * @return Student
     */
    public function setGradeClass(GradeClass $gradeClass): Student
    {
        $this->gradeClass = $gradeClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     *
     * @return Student
     */
    public function setBarcode(string $barcode): Student
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param StudentParent $parent
     *
     * @return Student
     */
    public function addParent(StudentParent $parent): Student
    {
        $this->parents->add($parent);
        return $this;
    }


    /**
     * @param StudentParent $parent
     *
     * @return Student
     */
    public function removeParent(StudentParent $parent): Student
    {
        $this->parents->removeElement($parent);
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName(string $firstName): Student
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName(string $lastName): Student
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Student
     */
    public function setEmail(string $email): Student
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
     * @return Student
     */
    public function setActive(bool $isActive): Student
    {
        $this->isActive = $isActive;
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
            $this->email,
            $this->barcode,
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
            $this->email,
            $this->barcode,
            $this->roles,
            $this->isActive
            ) = unserialize($serialized);
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
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
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
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return null The password
     */
    public function getPassword()
    {
        return null;
    }
}

