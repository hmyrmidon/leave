<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;



class UserManager extends BaseManager
{
    const USER_MANAGER = 'app.user_manager';

    public function addUser ($username, $lastName, $email, $password)
    {
        $user = new \AppBundle\Entity\User();

        $pass = crypt($password);
        $user->setUsername($username);
        $user->setLastName($lastName);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($pass);
        $user->setEnabled(1);

        $this->save($user);
        $this->flushAndClear();

        return $user;
    }
}
