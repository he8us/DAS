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
use UserBundle\Entity\User;

class RoleService
{

    private $roleHierarchy;

    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
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


        foreach ($user->getRoles() as $userRole){
            if(in_array($role, $this->roleHierarchy->getReachableRoles([new Role($userRole)]))){
                return true;
            }
        }

        return false;
    }

}
