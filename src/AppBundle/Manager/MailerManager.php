<?php

namespace AppBundle\Manager;

use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManagerInterface;

class MailerManager 
{
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
     * @param \AppBundle\Manager\EntityManagerInterface $entityManager
     * @param type $mailer
     * @param \AppBundle\Manager\EngineInterface $templating
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, $mailer, EngineInterface $templating)
    {
        $this->entityManager = $entityManager;
        $this->mailer        = $mailer;
        $this->templating    = $templating;
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
}
