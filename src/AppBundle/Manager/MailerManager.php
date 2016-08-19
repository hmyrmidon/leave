<?php

namespace AppBundle\Manager;

use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class MailerManager extends BaseManager
{
    const MAILER_MANAGER = 'app.mailer_manager';
    const FROM = 'contact@bocasay.fr';

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
        $this->translator = $translator;
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
                ->setSubject($this->translator->trans($subject, array(), 'common'))
                ->setBody($this->templating->render($template, $body))
                ->setContentType('text/html');

            return $this->mailer->send($message);
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    public function sendEmail(\AppBundle\Entity\User $user, $pass, $subjectMail, $templateMail)
    { 
        $from     = self::FROM;
        $to       = $user->getEmail();
        $subject  = $subjectMail;
        $template = $templateMail;
        $body     = array(
            'name'            => $user->getUsername(),
            'email'           => $to,
            'pass'            => $pass
        );
        $this->sendMessage($from, $to, $subject, $template, $body);
    }
}
