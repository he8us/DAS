<?php

namespace UserBundle\Entity;

use CourseBundle\Entity\CourseContent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table(name="teacher")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class Teacher extends User
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\CourseContent", inversedBy="teachers")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $courses;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->roles = ['ROLE_TEACHER'];
    }

    /**
     * @return ArrayCollection
     */
    public function getCourses(): ArrayCollection
    {
        return $this->courses;
    }

    /**
     * @param CourseContent $course
     *
     * @return Teacher
     */
    public function addCourses(CourseContent $course): Teacher
    {
        $this->courses->add($course);
        return $this;
    }


    /**
     * @param CourseContent $course
     *
     * @return Teacher
     */
    public function removeCourse(CourseContent $course): Teacher
    {
        $this->courses->remove($course);
        return $this;
    }
}

