<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\FirebaseNotification;
use Symfony\Component\Notifier\Notification\Notification;

class FirebaseNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): Notification
    {
        return new FirebaseNotification();
    }

    public static function getDefaultIndexName(): string
    {
        return 'firebase';
    }
}