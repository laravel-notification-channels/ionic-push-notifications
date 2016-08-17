<?php

namespace NotificationChannels\IonicPushNotifications\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Ionic Push responded with an error: `{$response->getBody()->getContents()}`");
    }
}
