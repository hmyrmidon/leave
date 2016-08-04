<?php

namespace AppBundle\Listener;


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
        dump('request sended');
    }
}