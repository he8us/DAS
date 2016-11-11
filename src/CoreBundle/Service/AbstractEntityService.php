<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Service;

use CoreBundle\Repository\AbstractRepository;
use CourseBundle\Entity\Lesson;
use CourseBundle\Repository\LessonRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\Student;
use UserBundle\Repository\StudentRepository;

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

    /**
     * @param UserInterface $user
     * @param \DateTime     $start
     * @param \DateTime     $end
     *
     * @return array
     */
    abstract public function getCoursesForInterval(UserInterface $user, \DateTime $start, \DateTime $end);

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
     * @param null $entity
     *
     * @return ObjectManager|null
     */
    protected function getManager($entity = null)
    {
        $entity = isset($entity) ? $entity : $this->entityClass;

        return $this->managerRegistry->getManagerForClass($entity);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAllNotDeletedQueryBuilder()->getQuery()->getResult();
    }

    /**
     * @return AbstractRepository
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository($this->entityClass);
    }

    /**
     * @return StudentRepository
     */
    protected function getStudentRepository()
    {
        return $this->getManager(Student::class)->getRepository(Student::class);
    }

    /**
     * @return LessonRepository
     */
    protected function getLessonRepository()
    {
        return $this->getManager(Lesson::class)->getRepository(Lesson::class);
    }

}
