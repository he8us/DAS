<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Coordinator
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class Coordinator extends User
{

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CMSBundle\Entity\Page", mappedBy="author")
     */
    private $pages;


    public function __construct()
    {
        parent::__construct();
        $this->pages = new ArrayCollection();
        $this->roles = ['ROLE_COORDINATOR'];
    }


}

