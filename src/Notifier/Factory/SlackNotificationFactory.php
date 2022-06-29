<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements IterableFactoryInterface, NotificationFactoryInterface
{

    public function createNotification(string $message): Notification
    {
        return new SlackNotification();
    }

    public static function getDefaultIndexName(): string
    {
        return 'slack';
    }
}