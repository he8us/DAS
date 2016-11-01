<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractEntityService
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;


    protected $entityClass;

    /**
     * CategoryService constructor.
     *
     * @param ManagerRegistry $managerRegistry
     *
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function delete($entity)
    {
        $entity->setDeletedAt(new \DateTime());
        $this->save($entity);
    }

    /**
     * @param object $entity
     *
     * @return object
     */
    public function save($entity)
    {
        $entityManager = $this->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        return $entity;
    }

    /**
     * @return ObjectManager|null
     */
    protected function getManager()
    {
        return $this->managerRegistry->getManagerForClass($this->entityClass);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository():EntityRepository
    {
        return $this->getManager()->getRepository($this->entityClass);
    }
}
