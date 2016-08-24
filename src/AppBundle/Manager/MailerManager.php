<?php

namespace AppBundle\Manager;

use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class MailerManager extends BaseManager
{
    const MAILER_MANAGER = 'app.mailer_manager';

    /**
     *
     * @var Mailer $mailer
     */
    protected $mailer;

    /**
     *
     * @var EngineInterface $templating
     */
    protected $templating;

    /**
     *
     * @var Translator $translator
     */
    protected $translator;

    /**
     * 
     * @param \AppBundle\Manager\EntityManagerInterface $entityManager
     * @param type $mailer
     * @param \AppBundle\Manager\EngineInterface $templating
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, $router, $mailer, EngineInterface $templating, Translator $translator)
    {
        parent::__construct($entityManager, $router);
        $this->mailer        = $mailer;
        $this->templating    = $templating;
        $this->translator    = $translator;
    }

    /**
     * sendMessage
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array  $body
     *
     * @return boolean
     */
    public function sendMessage($from, $to, $subject, $template, $body)
    {
        try {
            $message = \Swift_Message::newInstance()
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($this->translator->trans($subject, array(), 'label'))
                ->setBody($this->templating->render($template, $body))
                ->setContentType('text/html');

            return $this->mailer->send($message);
        } catch (\Exception $e) {
            //return $e->getMessage(); 
            dump($e->getMessage());die;
        }
    }

    public function sendEmail(\AppBundle\Entity\User $user, $pass, $subjectMail, $templateMail, $sendMail, $fromMail, $bodyMail = array())
    {
        $from     = $fromMail;
        $to       = $sendMail;
        $subject  = $subjectMail;
        $template = $templateMail;
        $content  = array(
            'name'            => $user->getUsername(),
            'email'           => $to,
            'pass'            => $pass
        );
        $body = array_merge($content, $bodyMail);
        $this->sendMessage($from, $to, $subject, $template, $body);
    }

    public function sendMultipleEmailToValidator($subjectMail, $templateMail, $users, $fromMail)
    {
        $employee = $this->entityManager->getRepository('AppBundle:Employee');
        foreach ($users as $user) {
            $listUser = $employee->getEmployeeListByValidator($user->getValidator());
            $body = array(
                'listUser' => $listUser
            ); 
            $this->sendEmail($user->getValidator(), '', $subjectMail, $templateMail, $user->getValidator()->getEmail(), $fromMail, $body);
        }
    }
}
