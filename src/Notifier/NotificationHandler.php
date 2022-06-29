<?php

namespace App\Notifier;

use App\Notifier\Factory\ChainNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;

class NotificationHandler
{
    private $factory;

    private $notifier;

    public function __construct(ChainNotificationFactory $factory, NotifierInterface $notifier)
    {
        $this->factory = $factory;
        $this->notifier = $notifier;
    }

    public function handle($message, $user)
    {
        $this->notifier->send($this->factory->createNotification($message, $user->getPreferedChannel()));
    }
}