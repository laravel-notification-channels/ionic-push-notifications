# Ionic push notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/ionic-push-notifications)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/ionic-push-notifications/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/ionic-push-notifications)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/wunderlist/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/wunderlist/?branch=master)
[![StyleCI](https://styleci.io/repos/65854274/shield)](https://styleci.io/repos/65854274)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/4c4c26c-a469-40ce-903b-cd49d2269373.svg?style=flat-square)](https://insight.sensiolabs.com/projects/4c4c26c-a469-40ce-903b-cd49d2269373)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/ionic-push-notifications)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/ionic-push-notifications.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/ionic-push-notifications)

This package makes it easy to send [Ionic Push Notifications](http://docs.ionic.io/docs/push-overview) with Laravel 5.3.

## Content

- [Installation](#installation)
- [Usage](#usage)
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

``` php
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
        return IonicPushMessage::create($data);
    }
}
```

In order to let your Notification know which device token to send to, add the `routeNotificationForIonicPush` method to your Notifiable model.

This method needs to return the device token of the user.

```php
public function routeNotificationForIonicPush()
{
    return $this->device_token;
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m.pociot@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Mark Beech](https://github.com/JayBizzle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
