<?php

namespace CourseBundle\Entity;

use UserBundle\Entity\Titular;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class
 *
 * @ORM\Table(name="grade_class", uniqueConstraints={@ORM\UniqueConstraint(name="grade_class_unique", columns={"grade_id", "section"})})
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\GradeClassRepository")
 */
class GradeClass
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
     * @var Grade
     *
     * @ORM\ManyToOne(targetEntity="CourseBundle\Entity\Grade", inversedBy="sections")
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
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get grade
     * @return Grade
     */
    public function getGrade() : Grade
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param Grade $grade
     *
     * @return GradeClass
     */
    public function setGrade(Grade $grade) : GradeClass
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return string
     */
    public function getSection(): string
    {
        return $this->section;
    }

    /**
     * @param string $section
     *
     * @return GradeClass
     */
    public function setSection(string $section) : GradeClass
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return Titular
     */
    public function getTitular(): Titular
    {
        return $this->titular;
    }

    /**
     * @param Titular $titular
     *
     * @return GradeClass
     */
    public function setTitular(Titular $titular): GradeClass
    {
        $this->titular = $titular;
        return $this;
    }
}

