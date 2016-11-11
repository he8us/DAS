<?php

namespace CourseBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use UserBundle\Entity\Student;
use UserBundle\Entity\Teacher;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson", )
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Grade", mappedBy="lessons")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id", onDelete="SET NULL")
    )
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
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Student", inversedBy="lessons")
     */
    private $students;


    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->date = new \DateTime();
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
     * Get date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param DateTime $date
     *
     * @return Lesson
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

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
     * @param Student $student
     *
     * @return Lesson
     */
    public function addStudent(Student $student)
    {
        $this->students->add($student);
        return $this;
    }

    /**
     * @param Student $student
     *
     * @return $this
     */
    public function removeStudent(Student $student)
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

