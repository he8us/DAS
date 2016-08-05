<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Avatar
 *
 * @ORM\Table(name="profile_picture")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ProfilePictureRepository")
 * @Vich\Uploadable()
 */
class ProfilePicture
{
    use TimestampableEntity;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="profile_picture", fileNameProperty="profile_picture_name")
     *
     * @Assert\Image(
     *      minWidth = 200,
     *      maxWidth = 2000,
     *      minHeight = 200,
     *      maxHeight = 2000,
     *      mimeTypes = "image/*",
     *      maxSize = "5M"
     * )
     *
     * @var File
     */
    protected $profilePictureFile;

    /**
     * @ORM\Column(name="profile_picture_name", type="string", length=255)
     *
     * @var string
     */
    protected $profilePictureName;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToOne(
     *     targetEntity="UserBundle\Entity\User",
     *     inversedBy="profilePicture"
     * )
     * @ORM\JoinColumn(name="id", referencedColumnName="profile_picture_id", onDelete="SET NULL")
     */
    private $id;

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
     * @return string
     */
    public function getProfilePictureName()
    {
        return $this->profilePictureName;
    }

    /**
     * @param string $profilePictureName
     *
     * @return ProfilePicture
     */
    public function setProfilePictureName(string $profilePictureName): ProfilePicture
    {
        $this->profilePictureName = $profilePictureName;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getProfilePictureFile()
    {
        return $this->profilePictureFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $profilePictureFile
     *
     * @return ProfilePicture
     */
    public function setProfilePictureFile(File $profilePictureFile = null): ProfilePicture
    {
        $this->profilePictureFile = $profilePictureFile;

        if ($profilePictureFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }
}
