<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class AbstractRepository extends EntityRepository
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @return QueryBuilder
     */
    public function findAllNotDeletedQueryBuilder()
    {
        return $this->createQueryBuilder($this->alias)
            ->where($this->alias.'.deletedAt IS NULL');
    }

    /**
     * @return object[]
     */
    public function findAllNotDeleted()
    {
        return $this->findAllNotDeletedQueryBuilder()->getQuery()->getResult();
    }
}
