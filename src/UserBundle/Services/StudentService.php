<?php

namespace UserBundle\Services;

use CoreBundle\Service\AbstractLessonIntervalEntityService;
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
     * {@inheritdoc}
     */
    public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end)
    {
        return $this->getLessonRepository()->getLessonForStudentForInterval($user, $start, $end);
    }
}
