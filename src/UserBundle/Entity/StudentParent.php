<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * StudentParent
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class StudentParent extends User
{

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Student", mappedBy="parents")
     * @ORM\JoinColumn(name="children_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $children;


    /**
     * StudentParent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->children = new ArrayCollection();
        $this->roles = ['ROLE_STUDENT_PARENT'];
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }


    /**
     * @param Student $child
     *
     * @return StudentParent
     */
    public function addChild(Student $child)
    {
        $this->children[] = $child;
        return $this;
    }


    /**
     * @param Student $child
     *
     * @return StudentParent
     */
    public function removeChild(Student $child)
    {
        $this->children->removeElement($child);
        return $this;
    }
}

