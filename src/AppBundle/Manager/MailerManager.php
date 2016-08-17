<?php

namespace AppBundle\Manager;

use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class MailerManager extends BaseManager
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
           dump($e->getMessage());die;
        }
    }
}
