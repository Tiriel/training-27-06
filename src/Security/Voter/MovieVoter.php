<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieVoter extends Voter
{
    public const EDIT = 'MOVIE_EDIT';
    public const VIEW = 'MOVIE_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($subject->getRated() === 'G') {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->checkEdit($subject, $user);
            case self::VIEW:
                return $this->checkView($subject, $user);
        }

        return false;
    }

    private function checkView(Movie $movie, User $user): bool
    {
        if (!$user->getBirthday()) {
            return false;
        }

        $age = $user->getBirthday()->diff(new \DateTimeImmutable())->y;

        switch ($movie->getRated()) {
            case 'PG':
            case 'PG-13':
                return $age >= 13;
            case 'NC-17':
            case 'R':
                return $age >= 17;
        }

        return false;
    }

    private function checkEdit(Movie $movie, User $user): bool
    {
        return $this->checkView($movie, $user) /** && $movie->addedBy === $user */;
    }
}
