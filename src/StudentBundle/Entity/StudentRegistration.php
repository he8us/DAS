<?php

namespace StudentBundle\Entity;

use CourseBundle\Entity\Lesson;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use UserBundle\Entity\Student;

/**
 * StudentRegistration
 *
 * @ORM\Table(name="student_registration")
 * @ORM\Entity(repositoryClass="StudentBundle\Repository\StudentRegistrationRepository")
 */
class StudentRegistration
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
     * @var \DateTime
     *
     * @ORM\Column(name="check_in", type="datetime", nullable=true)
     */
    private $checkIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_out", type="datetime", nullable=true)
     */
    private $checkOut;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Student", inversedBy="registeredLessons")
     */
    private $student;

    /**
     * @var Lesson
     *
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\Lesson", inversedBy="studentRegistrations")
     */
    private $lesson;

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     *
     * @return StudentRegistration
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     *
     * @return StudentRegistration
     */
    public function setLesson(Lesson $lesson)
    {
        $this->lesson = $lesson;
        return $this;
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
     * Get checkIn
     *
     * @return \DateTime
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * Set checkIn
     *
     * @param \DateTime $checkIn
     *
     * @return StudentRegistration
     */
    public function setCheckIn(\DateTime $checkIn)
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    /**
     * Get checkOut
     *
     * @return \DateTime
     */
    public function getCheckOut()
    {
        return $this->checkOut;
    }

    /**
     * Set checkOut
     *
     * @param \DateTime $checkOut
     *
     * @return StudentRegistration
     */
    public function setCheckOut(\DateTime $checkOut)
    {
        $this->checkOut = $checkOut;

        return $this;
    }
}

