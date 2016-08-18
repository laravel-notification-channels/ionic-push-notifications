<?php

namespace NotificationChannels\IonicPushNotifications\Test;

use Illuminate\Support\Arr;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;
use PHPUnit_Framework_TestCase;

class MessageTest extends PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\IonicPushNotifications\IonicPushMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new IonicPushMessage('my-security-profile');
    }

    /** @test */
    public function it_accepted_a_security_profile_when_constructing_a_message()
    {
        $this->assertEquals('my-security-profile', Arr::get($this->message->toArray(), 'profile'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = IonicPushMessage::create('my-security-profile');

        $this->assertEquals('my-security-profile', Arr::get($this->message->toArray(), 'profile'));
    }

    /** @test */
    public function by_default_it_will_use_tokens_as_user_identifier()
    {
        $this->assertEquals($this->message->getSendToType(), 'tokens');
    }

    /** @test */
    public function it_can_set_the_title()
    {
        $this->message->title('myTitle');

        $this->assertEquals('myTitle', Arr::get($this->message->toArray(), 'notification.title'));
    }

    /** @test */
    public function it_can_set_the_message()
    {
        $this->message->message('myMessage');

        $this->assertEquals('myMessage', Arr::get($this->message->toArray(), 'notification.message'));
    }

    /** @test */
    public function it_can_set_ios_specific_options()
    {
        $this->message->iosBadge(5);

        $this->assertEquals(5, Arr::get($this->message->toArray(), 'notification.ios.badge'));
    }

    /** @test */
    public function it_can_set_android_specific_options()
    {
        $this->message->androidIcon('ionitron.png');

        $this->assertEquals('ionitron.png', Arr::get($this->message->toArray(), 'notification.android.icon'));
    }

    /** @test */
    public function it_converts_camel_case_method_name_to_snake_case_array_key()
    {
        $this->message->iosContentAvailable(1);

        $this->assertTrue(Arr::has($this->message->toArray(), 'notification.ios.content_available'));
    }
}
