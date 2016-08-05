<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CourseTitular
 *
 * @ORM\Table(name="course_titular")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class CourseTitular extends User
{

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\CourseContent", mappedBy="titulars")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $courses;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Grade", mappedBy="courseTitulars")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $grades;


    /**
     * CourseTitular constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->roles = ['ROLE_COURSE_TITULAR'];
    }
}

