<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CourseBundle\Service;

use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\CourseContent;

/**
 * Class CourseContentService
 *
 * @package CourseBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CourseContentService extends AbstractEntityService
{

    /**
     * @var string
     */
    protected $entityClass = CourseContent::class;
}
