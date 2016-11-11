<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TeacherBundle\Service;

use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\Lesson;
use CourseBundle\Repository\LessonRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Teacher;

/**
 * Class TeacherService
 *
 * @package TeacherBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class TeacherService extends AbstractEntityService
{
    protected $entityClass = Teacher::class;

    /**
     * @param Teacher $teacher
     *
     * @return Lesson[]
     */
    public function getNextLessonForTeacher(Teacher $teacher)
    {
        return $this->getLessonRepository()->getNextLessonsForTeacher($teacher);
    }

    /**
     * @param UserInterface $user
     * @param \DateTime     $start
     * @param \DateTime     $end
     *
     * @return array
     */
    public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end)
    {
        return $this->getLessonRepository()->getLessonForTeacherForInterval($user, $start, $end);
    }

    /**
     * @param int $id
     *
     * @return Lesson
     */
    public function findById(int $id)
    {
        return $this->getRepository()->find($id);
    }

}
