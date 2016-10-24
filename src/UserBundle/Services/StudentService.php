<?php

namespace UserBundle\Services;

use CoreBundle\Service\AbstractEntityService;
use UserBundle\Entity\Student;
use UserBundle\Entity\User;

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
}
