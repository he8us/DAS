<?php

namespace CourseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;


/**
 * CourseContent
 *
 * @ORM\Table(name="course_content",uniqueConstraints={
 *          @UniqueConstraint(name="IDX_PARENT", columns={"parent_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\CourseContentRepository")
 */
class CourseContent
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $section;


    /**
     * @var CourseContent
     *
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\CourseContent")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Teacher", mappedBy="courses")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $teachers;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Grade", inversedBy="courses")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $grades;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\CourseTitular", inversedBy="courses")
     * @ORM\JoinColumn(name="titular_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $titulars;


    /**
     * CourseContent constructor.
     */
    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->titulars = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set name
     *
     * @param string $section
     *
     * @return CourseContent
     */
    public function setSection(string $section): CourseContent
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return CourseContent|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param CourseContent $parent
     *
     * @return CourseContent
     */
    public function setParent(CourseContent $parent): CourseContent
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeachers(): ArrayCollection
    {
        return $this->teachers;
    }

    /**
     * @param Teacher $teacher
     *
     * @return CourseContent
     */
    public function addTeacher(Teacher $teacher): CourseContent
    {
        $this->teachers->add($teacher);
        return $this;
    }


    /**
     * @param Teacher $teacher
     *
     * @return CourseContent
     */
    public function removeTeacher(Teacher $teacher)
    {
        $this->teachers->removeElement($teacher);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTitulars(): ArrayCollection
    {
        return $this->titulars;
    }

    /**
     * @param Titular $teacher
     *
     * @return CourseContent
     */
    public function addTitular(Titular $teacher): CourseContent
    {
        $this->titulars->add($teacher);
        return $this;
    }


    /**
     *
     * @param Titular $teacher
     *
     * @return CourseContent
     */
    public function removeTitular(Titular $teacher)
    {
        $this->titulars->removeElement($teacher);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrades(): ArrayCollection
    {
        return $this->grades;
    }

    /**
     *
     * @param Grade $grade
     *
     * @return CourseContent
     */
    public function addGrade(Grade $grade): CourseContent
    {
        $this->grades->add($grade);
        return $this;
    }

    /**
     *
     * @param Grade $grade
     *
     * @return CourseContent
     */
    public function removeGrade(Grade $grade): CourseContent
    {
        $this->grades->removeElement($grade);
        return $this;
    }


}

