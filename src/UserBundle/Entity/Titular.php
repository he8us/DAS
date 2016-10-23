<?php

namespace UserBundle\Entity;

use CourseBundle\Entity\GradeClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Titular
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class Titular extends User
{

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CourseBundle\Entity\GradeClass", mappedBy="titular")
     * @ORM\JoinColumn(name="grade_class_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $gradeClasses;


    /**
     * Titular constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->gradeClasses = new ArrayCollection();
        $this->roles = ['ROLE_TITULAR'];
    }

    /**
     * @return ArrayCollection
     */
    public function getGradeClasses(): ArrayCollection
    {
        return $this->gradeClasses;
    }

    /**
     *
     * @param GradeClass $gradeClass
     *
     * @return Titular
     */
    public function addGradeClass(GradeClass $gradeClass): Titular
    {
        $this->gradeClasses->add($gradeClass);
        return $this;
    }

    /**
     *
     * @param GradeClass $gradeClass
     *
     * @return Titular
     */
    public function removeGradeClass(GradeClass $gradeClass): Titular
    {
        $this->gradeClasses->removeElement($gradeClass);
        return $this;
    }
}
