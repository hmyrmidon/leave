<?php

namespace AppBundle\Listener;


use AppBundle\Entity\VacationRequest;

class VacationListener
{
    public function onWaiting(){}
    public function onValidate(){
        dump('onValidate');
    }
    public function onDenied(){}
    public function onUserCreated(){}
    public function onUserUpdates(){}
    public function onStatusChanged(){}
    public function onSubmitRequest($event)
    {
        dump($event->getEmployee());die;
        dump('sended email to '.$event->getEmployee());
    }
}