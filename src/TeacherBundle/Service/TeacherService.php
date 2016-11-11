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
     */
    public function getNextLessonForTeacher(Teacher $teacher)
    {

        $this->getLessonRepository()->getNextLessonsForTeacher($teacher);

    }

    /**
     * @return LessonRepository
     */
    private function getLessonRepository()
    {
         return $this->getManager(Lesson::class)->getRepository(Lesson::class);
    }

    /**
     * @param Teacher   $teacher
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    public function getCoursesForInterval(Teacher $teacher, \DateTime $start, \DateTime $end)
    {
        return $this->getLessonRepository()->getLessonForTeacherForInterval($teacher, $start, $end);
    }

}
