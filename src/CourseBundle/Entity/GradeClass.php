<?php

namespace CourseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use UserBundle\Entity\Student;
use UserBundle\Entity\Titular;

/**
 * Class
 *
 * @ORM\Table(name="grade_class", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UNIQ_GRADE_CLASS", columns={"grade_id", "section"})
 * })
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\GradeClassRepository")
 */
class GradeClass
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Grade
     *
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\Grade", inversedBy="gradeClasses")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=30)
     */
    private $section;


    /**
     * @var Titular
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Titular", inversedBy="gradeClasses")
     * @ORM\JoinColumn(name="titular_id", referencedColumnName="id",  onDelete="SET NULL")
     */
    private $titular;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Student", mappedBy="gradeClass")
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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
     * Get grade
     *
     * @return Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param Grade $grade
     *
     * @return $this
     */
    public function setGrade(Grade $grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     *
     * @return $this
     */
    public function setSection(string $section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return Titular
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * @param Titular $titular
     *
     * @return $this
     */
    public function setTitular(Titular $titular)
    {
        $this->titular = $titular;
        return $this;
    }

    /**
     * @param Student $student
     *
     * @return $this
     *
     */
    public function addStudents(Student $student)
    {
        $this->students->add($student);
        return $this;
    }

    /**
     * @param Student $student
     *
     * @return $this
     */
    public function deleteStudent(Student $student)
    {
        $this->students->removeElement($student);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStudents()
    {
        return $this->students;
    }
}

