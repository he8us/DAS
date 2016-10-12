<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\Coordinator;
use UserBundle\Entity\CourseTitular;
use UserBundle\Entity\StudentParent;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;
use UserBundle\Entity\User;

class PasswordEncoder
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * PasswordEncoder constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return object|void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return object|void
     */
    private function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $this->getEntity($args);

        if(!$entity){
            return;
        }

        return $this->encodePassword($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return object|void
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return object
     */
    private function getEntity(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$this->validateEntity($entity)){
            return;
        }

        return $entity;
    }

    /**
     * @param $entity
     */
    private function encodePassword($entity)
    {
        if (!$entity->getPlainPassword()) {
            return;
        }

        $encodedPassword = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encodedPassword);

        return $entity;
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    private function validateEntity($entity):bool
    {

        if (
            !$entity instanceof User &&
            !$entity instanceof Coordinator &&
            !$entity instanceof Teacher &&
            !$entity instanceof Titular &&
            !$entity instanceof CourseTitular &&
            !$entity instanceof StudentParent
        ) {
            return false;
        }
        return true;
    }
}
