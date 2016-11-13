<?php

namespace CourseBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use StudentBundle\Entity\StudentRegistration;
use UserBundle\Entity\Teacher;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson")
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\LessonRepository")
 */
class Lesson
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
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="room", type="string", length=10)
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", nullable=true)
     */
    private $remarks;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Grade", inversedBy="lessons")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $grades;

    /**
     * @var Teacher
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Teacher", inversedBy="lessons")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false, onDelete="CASCADE"))
     */
    private $teacher;

    /**
     * @var CourseContent
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\CourseContent", inversedBy="lessons")
     * @ORM\JoinColumn(name="course_content_id", referencedColumnName="id", nullable=false, onDelete="CASCADE"))
     */
    private $content;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StudentBundle\Entity\StudentRegistration", mappedBy="lesson")
     */
    private $studentRegistrations;

    /**
     * Lesson constructor.
     */
    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->startDate = new \DateTime();
        $this->studentRegistrations = new ArrayCollection();
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
     * Get date
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set date
     *
     * @param DateTime $startDate
     *
     * @return Lesson
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get room
     *
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set room
     *
     * @param string $room
     *
     * @return Lesson
     */
    public function setRoom(string $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Lesson
     */
    public function setRemarks(string $remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param Teacher $teacher
     *
     * @return $this
     */
    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return CourseContent
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param CourseContent $content
     *
     * @return $this
     */
    public function setContent(CourseContent $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param Grade $grade
     *
     * @return Lesson
     */
    public function addGrade(Grade $grade)
    {
        $this->grades->add($grade);
        return $this;
    }

    /**
     * @param Grade $grade
     *
     * @return $this
     */
    public function deleteGrade(Grade $grade)
    {
        $this->grades->removeElement($grade);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     *
     * @return $this
     */
    public function setEndDate(DateTime $endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param StudentRegistration $studentRegistration
     *
     * @return $this
     */
    public function addStudentRegistration(StudentRegistration $studentRegistration)
    {
        $this->studentRegistrations->add($studentRegistration);
        return $this;
    }

    /**
     * @param StudentRegistration $studentRegistration
     *
     * @return $this
     */
    public function deleteStudentRegistration(StudentRegistration $studentRegistration)
    {
        $this->studentRegistrations->removeElement($studentRegistration);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStudentRegistrations()
    {
        return $this->studentRegistrations;
    }
}

