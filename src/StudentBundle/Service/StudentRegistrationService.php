<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace StudentBundle\Service;


use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\Lesson;
use StudentBundle\Entity\StudentRegistration;
use StudentBundle\Repository\StudentRegistrationRepository;
use UserBundle\Entity\Student;

class StudentRegistrationService extends AbstractEntityService
{
    protected $entityClass = StudentRegistration::class;


    /**
     * @param Lesson  $lesson
     * @param Student $student
     *
     * @return StudentRegistration
     */
    public function register(Lesson $lesson, Student $student)
    {
        $registration = new StudentRegistration();

        $registration
            ->setStudent($student)
            ->setLesson($lesson);

        $this->save($registration);

        return $registration;
    }

    /**
     * @param Student $student
     * @param Lesson  $lesson
     *
     * @return StudentRegistration
     */
    public function findByStudentAndLesson(Student $student, Lesson $lesson)
    {
        return $this->getRepository()->findByStudentAndLesson($student, $lesson);
    }

    /**
     * @param Lesson $lesson
     *
     * @return StudentRegistration
     */
    public function findByLesson(Lesson $lesson)
    {
        return $this->getRepository()->findByLesson($lesson);
    }


    public function isRegisteredForLesson(Student $student, Lesson $lesson)
    {
        /** @var StudentRegistrationRepository $repo */
        $count = (int) $this->getRepository()->countByStudentAndLesson($student, $lesson);

        return $count > 0;
    }
}
