<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use AppBundle\Manager\MailerManager;


class UserManager extends BaseManager
{
    const USER_MANAGER = 'app.user_manager';
    const FROM         = 'contact@bocasay.fr';

    /**
     *
     * @var Mailer $mailerClass 
     * 
     */
    private $mailerManager;

    /**
     * 
     * @param \AppBundle\Manager\EntityManagerInterface $entityManager
     * @param \AppBundle\Manager\Router $router
     * @param \AppBundle\Manager\MailerManager $mailerManager
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router, MailerManager $mailerManager)
    {
        parent::__construct($entityManager, $router);
        $this->mailerManager = $mailerManager;
    }

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

    public function sendEmailOnCreateUser(\AppBundle\Entity\User $user, $pass)
    {
       
        $url      = $this->route->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
        $from     = self::FROM;
        $to       = $user->getEmail();
        $subject  = 'email de première connection';
        $template = 'admin/emails/emailCreateUser.html.twig';
        $body     = array(
            'name'            => $user->getUsername(),
            'email'           => $to,
            'pass'            => $pass,
            'firstConnection' => $url
        );
        $this->mailerManager->sendMessage($from, $to, $subject, $template, $body); dump('test');die;
    }
}
