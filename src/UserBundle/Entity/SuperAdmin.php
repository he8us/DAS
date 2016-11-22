<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordinator
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class SuperAdmin extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_SUPER_ADMIN'];
    }


}

