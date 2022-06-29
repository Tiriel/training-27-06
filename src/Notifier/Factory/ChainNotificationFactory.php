<?php

namespace App\Notifier\Factory;

use Symfony\Component\Notifier\Notification\Notification;

class ChainNotificationFactory implements NotificationFactoryInterface
{
    private $factories;

    public function __construct(iterable $factories)
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function createNotification(string $message, string $channel = ''): Notification
    {
        return $this->factories[$channel]->createNotification($message);
    }
}