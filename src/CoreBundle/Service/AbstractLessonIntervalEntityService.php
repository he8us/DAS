<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Service;


use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractLessonIntervalEntityService extends AbstractEntityService
{

    /**
     * @param UserInterface $user
     * @param \DateTime     $start
     * @param \DateTime     $end
     *
     * @return array
     */
    abstract public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end);

}
