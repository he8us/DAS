<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CourseBundle\Service;

use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\GradeClass;

/**
 * Class GradeClassService
 *
 * @package CourseBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class GradeClassService extends AbstractEntityService
{
    /**
     * @var string
     */
    protected $entityClass = GradeClass::class;
}
