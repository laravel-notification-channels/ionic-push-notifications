# Ionic Push Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/ionic-push-notifications)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/ionic-push-notifications/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/ionic-push-notifications)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/ionic-push-notifications/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/ionic-push-notifications/?branch=master)
[![StyleCI](https://styleci.io/repos/65854274/shield)](https://styleci.io/repos/65854274)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/d4c4c26c-a469-40ce-903b-cd49d2269373.svg?style=flat-square)](https://insight.sensiolabs.com/projects/d4c4c26c-a469-40ce-903b-cd49d2269373)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/ionic-push-notifications)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/ionic-push-notifications)

This package makes it easy to send [Ionic Push Notifications](http://docs.ionic.io/docs/push-overview) with Laravel.

## Content

- [Installation](#installation)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/ionic-push-notifications
```

### Setting up the Ionic Push service

Add your Ionic Push Authentication Token to your `config/services.php`:

```php
// config/services.php
'ionicpush' => [
    'key' => env('IONIC_PUSH_API_KEY'),
]
```


## Usage

Now you can use the channel in your `via()` method inside the notification:

```php
use NotificationChannels\IonicPushNotifications\IonicPushChannel;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;
use Illuminate\Notifications\Notification;

class FriendRequest extends Notification
{
    public function via($notifiable)
    {
        return [IonicPushChannel::class];
    }

    public function toIonicPush($notifiable)
    {
        return IonicPushMessage::create('my-security-profile')
            ->title('Your title')
            ->message('Your message')
            ->sound('ping.aiff')
            ->payload(['foo' => 'bar']);
    }
}
```

You can easily set different settings for iOS and Android individually like this...

```php
use NotificationChannels\IonicPushNotifications\IonicPushChannel;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;
use Illuminate\Notifications\Notification;

class FriendRequest extends Notification
{
    public function via($notifiable)
    {
        return [IonicPushChannel::class];
    }

    public function toIonicPush($notifiable)
    {
        return IonicPushMessage::create('my-security-profile')
            ->iosMessage('Your iOS message')
            ->androidMessage('Your Android message')
            ->iosSound('ping.aiff')
            ->androidSound('ping.aiff');
    }
}
```

In order to let your Notification know which device token to send to, add the `routeNotificationForIonicPush` method to your Notifiable model.

This method needs to return the device token of the user (or the Ionic Auth email address, or Ionic userID of the user).
Do not forget to set the method of targeting users with `sendTo()` if necessary (see below).

```php
public function routeNotificationForIonicPush()
{
    return $this->device_token;
}
```

You can also return multiple tokens to send to a group of devices the user may own


```php
public function routeNotificationForIonicPush()
{
    return $this->device_tokens;
}
```

### Available Message methods

- `create()`: Accepts a string value of `your-security-profile`.
- `title()`: The title of your notification (for all platforms). Can be overwritten by platform specific `title` method (see below).
- `message()`: The message content of your notification (for all platforms). Can be overwritten by platform specific `message` method (see below). 
- `sound()`: The title of your notification (for all platforms). Can be overwritten by platform specific `sound` method (see below).
- `payload()`: An array of data to send with your notification. Can be overwritten by platform specific `payload` method (see below).
- `scheduled()`: Schedule a notification for future delivery. Accept `DateTime` object or a date as a string.
- `sendTo()`: Set the method of targeting users - tokens (default), user_ids, or emails.

#### iOS specific methods
[See here](http://legacy.docs.ionic.io/v2.0.0-beta/docs/push-sending-push#section-basic-api-usage) for full details on these methods.
- `iosMessage()`
- `iosTitle()`
- `iosBadge()`
- `iosPayload()`
- `iosSound()`
- `iosPriority()`
- `iosExpire()`
- `iosContentAvailable()`

#### Android specific methods
[See here](http://legacy.docs.ionic.io/v2.0.0-beta/docs/push-sending-push#section-basic-api-usage) for full details on these methods.
- `androidCollapseKey()`
- `androidContentAvailable()`
- `androidData()`
- `androidDelayWhileIdle()`
- `androidIcon()`
- `androidIconColor()`
- `androidMessage()`
- `androidPriority()`
- `androidSound()`
- `androidTag()`
- `androidTimeToLive()`
- `androidTitle()`


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m@rkbee.ch instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Mark Beech](https://github.com/JayBizzle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
