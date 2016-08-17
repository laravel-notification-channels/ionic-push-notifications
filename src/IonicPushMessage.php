<?php

namespace NotificationChannels\IonicPushNotifications;

use NotificationChannels\IonicPushNotifications\Exceptions\CouldNotCreateMessage;

class IonicPushMessage
{
    /** @var array */
    protected $data;

    /**
     * @param array $data
     *
     * @return static
     */
    public static function create($data = [])
    {
        return new static($data);
    }
    
    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
