<?php

namespace App\Service;

use App\Entity\Habit;
use App\Entity\Tracker;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class DashboardService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function getHabitsValuesForToday(User $user): array
    {
        $trackerRepository = $this->entityManager->getRepository(Tracker::class);
        $habits = $this->entityManager->getRepository(Habit::class)->findBy(['user' => $user]);
        
        $today = new \DateTime('today');
        $values = [];
        
        foreach ($habits as $habit) {
            $tracker = $trackerRepository->findOneBy([
                'habit' => $habit,
                'date' => $today,
                'user' => $user
            ]);
            
            if ($tracker) {
                $values[$habit->getId()] = [
                    'value' => $tracker->getValue(),
                    'points' => $tracker->getPoints(),
                ];
            }
        }
        
        return $values;
    }
} 