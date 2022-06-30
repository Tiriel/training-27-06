<?php

namespace App\EventSubscriber;

use App\Event\MovieEvent;
use App\Notifier\NotificationHandler;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MovieSubscriber implements EventSubscriberInterface
{
    private UserRepository $repository;
    private NotificationHandler $handler;
    private TokenStorageInterface $storage;

    public function __construct(UserRepository $repository, NotificationHandler $handler, TokenStorageInterface $storage)
    {
        $this->repository = $repository;
        $this->handler = $handler;
        $this->storage = $storage;
    }

    public function onMovieUnderage(MovieEvent $event)
    {
        //$admins = $this->repository->findAdmins();
        dump(sprintf("Underage movie: %s", $event->getMovie()->getTitle()));
/*        $this->handler->handle(
            sprintf("New underage movie viewing. Movie: %s - UserIdentifier: %s",
                $event->getMovie()->getTitle(),
                $this->storage->getToken()->getUserIdentifier()
            ),
            $admins
        );*/
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieEvent::UNDERAGE => 'onMovieUnderage',
        ];
    }
}
