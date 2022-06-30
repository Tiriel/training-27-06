<?php

namespace App\Notifier;

use App\Notifier\Factory\ChainNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class NotificationHandler
{
    private $factory;

    private $notifier;

    public function __construct(ChainNotificationFactory $factory, NotifierInterface $notifier)
    {
        $this->factory = $factory;
        $this->notifier = $notifier;
    }

    public function handle(string $message, $users)
    {
        if (!is_array($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $this->notifier->send(
                $this->factory->createNotification($message, $user->getPreferedChannel()),
                new Recipient($user->getEmail())
            );
        }
    }
}