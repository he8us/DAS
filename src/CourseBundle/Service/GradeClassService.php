<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CourseBundle\Service;

use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\Grade;
use CourseBundle\Entity\GradeClass;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class GradeClassService
 *
 * @package CourseBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class GradeClassService extends AbstractEntityService
{
    /**
     * @var string
     */
    protected $entityClass = GradeClass::class;

    /**
     * @var GradeService
     */
    private $gradeService;


    /**
     * @param ManagerRegistry $managerRegistry
     * @param GradeService    $gradeService
     */
    public function __construct(ManagerRegistry $managerRegistry, GradeService $gradeService){
        parent::__construct($managerRegistry);
        $this->gradeService = $gradeService;
    }


    /**
     * @param int    $gradeName
     * @param string $sectionName
     *
     * @return GradeClass|null
     */
    public function findOneByGradeNameAndSectionName(int $gradeName, string $sectionName)
    {
        return $this->getRepository()->findOneByGradeNameAndSectionName($gradeName, $sectionName);
    }


    public function createGradeClassByGradeNameAndSectionName($grade, $section)
    {
        $grade = $this->getGradeByName($grade);

        $grade_class = new GradeClass();

        $grade_class
            ->setSection(strtolower($section))
            ->setGrade($grade);

        $this->save($grade_class);

        return $grade_class;
    }

    /**
     * @return GradeService
     */
    private function getGradeService()
    {
        return $this->gradeService;
    }

    /**
     * @param int $gradeName
     *
     * @return Grade
     */
    private function getGradeByName(int $gradeName)
    {
        $grade = $this->getGradeService()->findByGradeName($gradeName);

        if(null !== $grade){
            return $grade;
        }

        $grade = $this->getGradeService()->createGradeByName($gradeName);

        return $grade;
    }


}
