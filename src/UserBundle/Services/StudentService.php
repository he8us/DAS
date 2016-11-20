<?php

namespace UserBundle\Services;

use CoreBundle\Service\AbstractLessonIntervalEntityService;
use CoreBundle\Service\RandomStringService;
use CourseBundle\Entity\GradeClass;
use CourseBundle\Service\GradeClassService;
use CourseBundle\Service\GradeService;
use Doctrine\Common\Persistence\ManagerRegistry;
use PHPExcel_Worksheet_Row;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Student;

/**
 * Class StudentService
 *
 * @package UserBundle\Services
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class StudentService extends AbstractLessonIntervalEntityService
{
    protected $entityClass = Student::class;

    /**
     * @var GradeClassService
     */
    private $gradeClassService;

    /**
     * @var GradeService
     */
    private $gradeService;

    /**
     * @var RandomStringService
     */
    private $randomStringService;

    /**
     * StudentService constructor.
     *
     * @param ManagerRegistry     $managerRegistry
     * @param GradeClassService   $gradeClassService
     * @param GradeService        $gradeService
     * @param RandomStringService $randomStringService
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        GradeClassService $gradeClassService,
        GradeService $gradeService,
        RandomStringService $randomStringService
    ) {
        parent::__construct($managerRegistry);
        $this->gradeClassService = $gradeClassService;
        $this->gradeService = $gradeService;
        $this->randomStringService = $randomStringService;
    }

    /**
     * {@inheritdoc}
     */
    public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end)
    {
        return $this->getLessonRepository()->getLessonForStudentForInterval($user, $start, $end);
    }

    /**
     * @param PHPExcel_Worksheet_Row $row
     */
    public function createStudentFromRow(PHPExcel_Worksheet_Row $row)
    {

        $iterator = $row->getCellIterator('A');

        /** @var \PHPExcel_Cell[] $data */
        $data = [];
        while ($iterator->valid()) {
            $data[] = $iterator->current();

            $iterator->next();
        }


        $number = $data[0]->getValue();
        $grade_class = $data[1]->getValue();
        $name = $data[2]->getValue();

        $this->newStudentFromExcel($number, $name, $grade_class);

    }

    /**
     * @param $number
     * @param $name
     * @param $grade_class
     *
     * @return Student
     */
    private function newStudentFromExcel($number, $name, $grade_class)
    {

        $name = $this->normalizeName($name);

        $firstName = array_pop($name);
        $lastName = implode(' ', $name);

        $grade_class = $this->getGradeClass($grade_class);

        $student = $this->findByName($firstName, $lastName);

        if(null !== $student){
            return $student;
        }

        $student = new Student();

        $student
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setGradeClass($grade_class)
            ->setNumber($number)
            ->setBarcode($this->getRandomString());

        $this->save($student);

        return $student;
    }

    /**
     * @param $name
     *
     * @return array
     */
    private function normalizeName($name)
    {
        $name = trim($name);
        $name = ucwords($name);
        $name = explode(' ', $name);

        return $name;
    }

    /**
     * @param $grade_class
     *
     * @return GradeClass
     */
    private function getGradeClass($grade_class)
    {
        $grade_class = trim($grade_class);

        $grade = (int) $grade_class[0];
        $section = substr($grade_class, 1);

        $grade_class = $this->getGradeClassService()->findOneByGradeNameAndSectionName($grade, $section);

        if (null !== $grade_class) {
            return $grade_class;
        }

        $grade_class = $this->createGradeClass($grade, $section);
        return $grade_class;
    }

    /**
     * @return GradeClassService
     */
    private function getGradeClassService()
    {
        return $this->gradeClassService;
    }

    /**
     * @param int    $grade
     * @param string $section
     *
     * @return GradeClass
     */
    private function createGradeClass(int $grade, string $section)
    {
        return $this->getGradeClassService()->createGradeClassByGradeNameAndSectionName($grade, $section);
    }

    /**
     * @param int $number
     *
     * @return Student|null
     */
    private function findByNumber(int $number)
    {
        return $this->getRepository()->findByNumber($number);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return Student|null
     */
    private function findByName(string $firstName, string $lastName)
    {
        return $this->getRepository()->findByName($firstName, $lastName);
    }

    /**
     * @return string
     */
    private function getRandomString()
    {
        return $this->getRandomStringService()->generateRandomString();
    }

    /**
     * @return RandomStringService
     */
    private function getRandomStringService()
    {
        return $this->randomStringService;
    }
}
