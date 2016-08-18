<?php

namespace AppBundle\Manager;


use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleManager
{
    const SERVICE_NAME = 'app.role_manager';
    private $roleHierarchy;

    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    public function isGranted($role, $user)
    {
        $role = new Role($role);

        foreach ($user->getRoles() as $userRole){
            if (in_array($role, $this->roleHierarchy->getReachableRoles(array(new Role($userRole))))){
                return true;
            }
        }
        return false;
    }
}