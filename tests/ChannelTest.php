<?php

namespace NotificationChannels\IonicPushNotifications\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\IonicPushNotifications\Exceptions\CouldNotSendNotification;
use NotificationChannels\IonicPushNotifications\Exceptions\InvalidConfiguration;
use NotificationChannels\IonicPushNotifications\IonicPushChannel;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;
use Orchestra\Testbench\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.ionicpush.key', 'IonicKey');

        $response = new Response(201);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://api.ionic.io/push/notifications',
                [
                    'body' => '{"tokens":"device_token","profile":"my-security-profile","notification":{"message":"A message to your user","ios":{"badge":1,"sound":"ping.aiff"}}}',
                    'headers' => [
                        'Authorization' => 'Bearer IonicKey',
                        'Content-Type' => 'application/json',
                    ],
                ])
            ->andReturn($response);

        $channel = new IonicPushChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->setExpectedException(InvalidConfiguration::class);

        $client = new Client();

        $channel = new IonicPushChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->app['config']->set('services.ionicpush.key', 'IonicKey');

        $response = new Response(500);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->andReturn($response);

        $channel = new IonicPushChannel($client);

        $this->setExpectedException(CouldNotSendNotification::class);

        $channel->send(new TestNotifiable(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForIonicPush()
    {
        return 'device_token';
    }
}


class TestNotification extends Notification
{
    public function toIonicPush($notifiable)
    {
        $data = [
            'profile' => 'my-security-profile',
            'notification' => [
                'message' => 'A message to your user',
                'ios' => [
                    'badge' => 1,
                    'sound' => 'ping.aiff',
                ],
            ],
        ];

        return IonicPushMessage::create('my-security-profile')
            ->message('A message to your user')
            ->profile('my-security-profile')
            ->iosBadge(1)
            ->iosSound('ping.aiff');
    }
}
