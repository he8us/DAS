<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\User;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{

    /**
     * @param string $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $qb = $this->getQueryBuilderForFindByRole($role);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $role
     *
     * @return QueryBuilder
     */
    private function getQueryBuilderForFindByRole($role):QueryBuilder
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . strtoupper($role) . '"%');
        return $qb;
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function findOneByRole($role)
    {
        $qb = $this->getQueryBuilderForFindByRole($role);

        $qb->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Used for Unique fields validation
     *
     * @param array $criteria
     *
     * @return array|\UserBundle\Entity\User[]
     */
    public function findByUniqueCriteria(array $criteria)
    {
        return $this->_em->getRepository('UserBundle:User')->findBy($criteria);
    }
}
