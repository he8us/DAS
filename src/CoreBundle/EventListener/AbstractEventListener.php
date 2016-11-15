<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CoreBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

abstract class AbstractEventListener
{
    /**
     * @param LifecycleEventArgs $args
     *
     * @return User|null
     */
    protected function getEntity(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$this->isEntityValid($entity)) {
            return null;
        }

        return $entity;
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    abstract protected function isEntityValid($entity):bool;

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|object
     */
    abstract protected function handleEvent(LifecycleEventArgs $args);
}
