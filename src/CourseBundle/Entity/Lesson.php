<?php

namespace CourseBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson")
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\LessonRepository")
 */
class Lesson
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
    public function getDate() : DateTime
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
    public function setDate(DateTime $date) : Lesson
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get room
     *
     * @return string
     */
    public function getRoom() : string
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
    public function setRoom(string $room) : Lesson
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks() : string
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
    public function setRemarks(string $remarks) : Lesson
    {
        $this->remarks = $remarks;

        return $this;
    }
}

