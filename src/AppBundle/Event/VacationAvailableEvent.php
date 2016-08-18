<?php

namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

final class VacationAvailableEvent
{
    const ON_WAITING        = 'app.on_waiting_event';
    const ON_VALIDATE       = 'app.on_validate_event';
    const ON_DENIED         = 'app.on_denied_event';
    const ON_USER_CREATED   = 'app.on_user_created_event';
    const ON_USER_UPDATED   = 'app.on_user_updated_event';
    const ON_USER_CONNECTED = 'app.on_user_connected_event';
    const ON_STATUS_CHANGED = 'app.on_status_changed_event';
    const ON_SUBMIT_VACATION = 'app.on_submit_vacation_event';
    const SEND_EMAIL_ON_VALIDATE_VACATION_REQUEST = 'app.send_email_on_validate_vacation_request';
}