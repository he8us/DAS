<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Services;


use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Translation\TranslatorInterface;
use UserBundle\Entity\Student;
use UserBundle\Entity\User;

class RoleService
{

    /**
     * @var RoleHierarchyInterface
     */
    private $roleHierarchy;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(RoleHierarchyInterface $roleHierarchy, TranslatorInterface $translator)
    {
        $this->roleHierarchy = $roleHierarchy;
        $this->translator = $translator;
    }


    /**
     * @param      $role
     * @param User $user
     *
     * @return bool
     */
    public function isGranted(string $role, User $user)
    {
        $role = new Role($role);

        foreach ($user->getRoles() as $userRole) {
            if (in_array($role, $this->roleHierarchy->getReachableRoles([new Role($userRole)]))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $role
     *
     * @return string|null
     */
    public function translate(string $role)
    {
        switch ($role) {
            case Student::ROLE_STUDENT:
                return $this->translator->trans("layout.user.role.student");

            case User::ROLE_STUDENT_PARENT:
                return $this->translator->trans("layout.user.role.parent");

            case User::ROLE_TEACHER:
                return $this->translator->trans("layout.user.role.teacher");

            case User::ROLE_TITULAR:
                return $this->translator->trans("layout.user.role.titular");

            case User::ROLE_COURSE_TITULAR:
                return $this->translator->trans("layout.user.role.course_titular");

            case User::ROLE_COORDINATOR:
                return $this->translator->trans("layout.user.role.coordinator");

            case User::ROLE_SUPER_ADMIN:
                return $this->translator->trans("layout.user.role.super_admin");
        }

        return;
    }

}
