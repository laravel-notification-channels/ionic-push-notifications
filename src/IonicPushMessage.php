<?php

namespace NotificationChannels\IonicPushNotifications;

class IonicPushMessage
{
    /** @var string */
    public $sendTo = 'tokens';

    /** @var string */
    public $profile;

    /** @var string */
    public $title = '';

    /** @var string */
    public $message = '';

    /** @var string */
    public $sound = '';

    /** @var array */
    public $payload = [];

    /** @var array */
    public $iosData = [];

    /** @var array */
    public $androidData = [];

    /**
     * @param array $data
     *
     * @return static
     */
    public static function create($profile)
    {
        return new static($profile);
    }

    /**
     * @param string $profile
     */
    public function __construct($profile)
    {
        $this->profile = $profile;
    }

    /**
     * Set the method of targeting users - tokens (default), user_ids, or emails.
     *
     * @param  string  $profile
     *
     * @return $this
     */
    public function sendTo($sendTo)
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Set the title.
     *
     * @param  string  $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the message.
     *
     * @param  string  $message
     *
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the security sound to use.
     *
     * @param  string  $sound
     *
     * @return $this
     */
    public function sound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * Send custom key/value data with your notifications.
     *
     * @param  array  $payload
     *
     * @return $this
     */
    public function payload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Dynamically add device specific data.
     *
     * @param string $method
     * @param array  $args
     *
     * @return object
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'ios') {
            $key = snake_case(substr($method, 3));

            $this->iosData[$key] = $args[0];
        } elseif (substr($method, 0, 7) == 'android') {
            $key = snake_case(substr($method, 7));

            $this->androidData[$key] = $args[0];
        }

        return $this;
    }

    /**
     * Get the method we want to use to send messages.
     *
     * @return string
     */
    public function getSendToType()
    {
        return $this->sendTo;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'profile' => $this->profile,
            'notification' => [
                'title' => $this->title,
                'message' => $this->message,
                'sound' => $this->sound,
            ],
        ];

        if (! empty($this->sound)) {
            $data['notification']['sound'] = $this->sound;
        }

        if (! empty($this->iosData)) {
            $data['notification']['ios'] = $this->iosData;
        }

        if (! empty($this->androidData)) {
            $data['notification']['android'] = $this->androidData;
        }

        if (! empty($this->payload)) {
            $data['notification']['payload'] = $this->payload;
        }

        return $data;
    }
}
