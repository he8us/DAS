<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Coordinator
 *
 * @ORM\Table(name="coordinator")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class Coordinator extends User
{

    /**
     * @var ArrayCollection
     */
    private $pages;


    public function __construct()
    {
        parent::__construct();
        $this->pages = new ArrayCollection();
        $this->roles = ['ROLE_COORDINATOR'];
    }


}

