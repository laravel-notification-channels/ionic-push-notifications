<?php

namespace NotificationChannels\IonicPushNotifications\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\Wunderlist\Exceptions\CouldNotSendNotification;
use NotificationChannels\Wunderlist\Exceptions\InvalidConfiguration;
use NotificationChannels\Wunderlist\WunderlistChannel;
use NotificationChannels\Wunderlist\WunderlistMessage;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_can_test()
    {
        $this->assertTrue(true);
    }

}
