<?php

namespace CourseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\GradeRepository")
 */
class Grade
{

    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="grade", type="integer", unique=true)
     */
    private $grade;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CourseBundle\Entity\GradeClass", mappedBy="grade")
     */
    private $sections;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\CourseContent", mappedBy="grades")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $courses;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\CourseTitular", inversedBy="grades")
     * @ORM\JoinColumn(name="course_titular_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $courseTitulars;

    /**
     * Grade constructor.
     */
    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->courseTitulars = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get grade
     *
     * @return int
     */
    public function getGrade() : int
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Grade
     */
    public function setGrade($grade) : Grade
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return GradeClass
     */
    public function getSections(): GradeClass
    {
        return $this->sections;
    }

    /**
     * @param GradeClass $class
     *
     * @return Grade
     */
    public function addSection(GradeClass $class): Grade
    {
        $this->sections->add($class);
        return $this;
    }

    /**
     * @param GradeClass $class
     *
     * @return Grade
     */
    public function removeSection(GradeClass $class): Grade
    {
        $this->sections->removeElement($class);
        return $this;
    }

    /**
     * @return CourseContent
     */
    public function getCourses(): CourseContent
    {
        return $this->courses;
    }

    /**
     * @param CourseContent $class
     *
     * @return Grade
     */
    public function addCourse(CourseContent $class): Grade
    {
        $this->sections->add($class);
        return $this;
    }

    /**
     * @param CourseContent $class
     *
     * @return Grade
     */
    public function removeCourse(CourseContent $class): Grade
    {
        $this->sections->removeElement($class);
        return $this;
    }
}

