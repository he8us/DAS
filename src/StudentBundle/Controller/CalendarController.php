<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace StudentBundle\Controller;


use CoreBundle\Controller\AbstractCalendarController;
use Symfony\Component\Security\Core\User\UserInterface;

class CalendarController extends AbstractCalendarController
{
    /**
     * {@inheritdoc}
     */
    protected function getLessonsForInterval(UserInterface $user, \DateTime $start, \DateTime $end)
    {
        $this->getStudentService()->getCoursesForInterval($user, $start, $end);
    }

}
