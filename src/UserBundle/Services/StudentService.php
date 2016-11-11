<?php

namespace UserBundle\Services;

use CoreBundle\Service\AbstractEntityService;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Student;

/**
 * Class StudentService
 *
 * @package UserBundle\Services
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class StudentService extends AbstractEntityService
{
    protected $entityClass = Student::class;

    /**
     * {@inheritdoc}
     */
    public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end)
    {
        return $this->getLessonRepository()->getLessonForStudentForInterval($user, $start, $end);
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function findById(int $id)
    {
        return $this->getStudentRepository()->find($id);
    }
}
