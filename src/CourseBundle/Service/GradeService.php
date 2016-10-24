<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CourseBundle\Service;


use CoreBundle\Service\AbstractEntityService;
use CourseBundle\Entity\Grade;

/**
 * Class GradeService
 *
 * @package CourseBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class GradeService extends AbstractEntityService
{

    /**
     * @var string
     */
    protected $entityClass = Grade::class;
}
