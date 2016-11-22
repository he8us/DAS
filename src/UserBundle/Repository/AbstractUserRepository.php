<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Repository;


use CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractUserRepository extends AbstractRepository implements UserLoaderInterface
{
    /**
     * Used for Unique fields validation
     *
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findByUniqueCriteria(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @return EntityRepository
     */
    abstract protected function getRepository();
}
