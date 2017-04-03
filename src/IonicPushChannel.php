<?php

namespace NotificationChannels\IonicPushNotifications;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use NotificationChannels\IonicPushNotifications\Exceptions\InvalidConfiguration;
use NotificationChannels\IonicPushNotifications\Exceptions\CouldNotSendNotification;

class IonicPushChannel
{
    const API_ENDPOINT = 'https://api.ionic.io/push/notifications';

    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\IonicPushNotifications\Exceptions\InvalidConfiguration
     * @throws \NotificationChannels\IonicPushNotifications\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $routing = collect($notifiable->routeNotificationFor('IonicPush'));
        // remove empty device tokens
        $routing->filter(function ($token) {
            return ! empty($token);
        });
        // if there are no valid device tokens then do not send the notification
        if (! $routing->count() > 0) {
            return;
        }

        $authorizationKey = config('services.ionicpush.key');

        if (is_null($authorizationKey)) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $message = $notification->toIonicPush($notifiable);

        $ionicPushData = array_merge(
            [$message->getSendToType() => $routing->all()],
            $message->toArray()
        );

        $response = $this->client->post(self::API_ENDPOINT, [
            'body' => json_encode($ionicPushData),
            'headers' => [
                'Authorization' => "Bearer {$authorizationKey}",
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 201) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
