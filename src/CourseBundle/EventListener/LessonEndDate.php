<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CourseBundle\EventListener;


use Carbon\Carbon;
use CoreBundle\EventListener\AbstractEventListener;
use CourseBundle\Entity\Lesson;
use Doctrine\ORM\Event\LifecycleEventArgs;
use UserBundle\Entity\Student;

class LessonEndDate extends AbstractEventListener
{


    /**
     * @param LifecycleEventArgs $args
     *
     * @return Lesson|null
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|Lesson
     */
    protected function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $this->getEntity($args);

        if (!$entity) {
            return;
        }

        return $this->setEndDate($entity);
    }


    /**
     * @param Lesson $lesson
     *
     * @return Lesson|null
     */
    private function setEndDate(Lesson $lesson)
    {
        if ($lesson->getEndDate()) {
            return null;
        }

        $startDate = Carbon::createFromTimestamp($lesson->getStartDate()->getTimestamp());
        $endDate = $startDate->addMinutes(50);

        $lesson->setEndDate($endDate);

        return $lesson;


    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|Student
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    protected function isEntityValid($entity):bool
    {
        return $entity instanceof Lesson;
    }
}
