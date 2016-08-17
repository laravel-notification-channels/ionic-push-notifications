<?php

namespace NotificationChannels\IonicPushNotifications\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send Ionic Push Notifications you need to add your authorization token to the `ionicpush` key of `config.services`.');
    }
}
