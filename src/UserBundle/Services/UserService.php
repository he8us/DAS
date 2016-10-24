<?php

namespace UserBundle\Services;

use CoreBundle\Service\AbstractEntityService;
use UserBundle\Entity\User;

/**
 * Class UserService
 *
 * @package UserBundle\DependencyInjection\Compiler
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserService extends AbstractEntityService
{
    protected $entityClass = User::class;
}
