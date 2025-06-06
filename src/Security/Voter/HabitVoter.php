<?php

namespace App\Security\Voter;

use App\Entity\Habit;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class HabitVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, ['view', 'edit', 'delete'])
            && $subject instanceof Habit;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Habit $habit */
        $habit = $subject;

        return match($attribute) {
            'view', 'edit', 'delete' => $this->canAccess($habit, $user),
            default => false,
        };
    }

    private function canAccess(Habit $habit, UserInterface $user): bool
    {
        return $habit->getUser()->getId() === $user->getId();
    }
} 