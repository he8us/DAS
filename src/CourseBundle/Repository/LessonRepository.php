<?php

namespace CourseBundle\Repository;

use Carbon\Carbon;
use CoreBundle\Repository\AbstractRepository;
use UserBundle\Entity\Teacher;

/**
 * LessonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LessonRepository extends AbstractRepository
{
    protected $alias = 'l';

    /**
     * @param Teacher $teacher
     *
     * @return array
     */
    public function getNextLessonsForTeacher(Teacher $teacher)
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.teacher = :tId')
            ->setParameter('tId', $teacher->getId())
            ->where('l.date > :now')
            ->setParameter('now', Carbon::now());

        return $query->getQuery()->getResult();
    }

    /**
     * @param Teacher   $teacher
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    public function getLessonForTeacherForInterval(Teacher $teacher, \DateTime $start, \DateTime $end)
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.teacher = :tId')
            ->setParameter('tId', $teacher->getId())
            ->andWhere('l.date > :start')
            ->setParameter('start', $start)
            ->andWhere('l.date < :end')
            ->setParameter('end', $end);

        return $query->getQuery()->getResult();
    }

    public function getLessonForStudentForInterval($user, $start, $end)
    {
    }
}
