<?php

namespace App\Service;

use App\Entity\Habit;
use App\Entity\Tracker;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TrackerService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function getTrackerDataForCurrentPeriod(User $user): array
    {
        $startDate = new \DateTime('first day of this month');
        $endDate = new \DateTime('last day of this month');
        
        $trackerRepository = $this->entityManager->getRepository(Tracker::class);
        $habits = $this->entityManager->getRepository(Habit::class)->findBy(['user' => $user]);
        
        $trackerData = [];
        foreach ($habits as $habit) {
            $trackers = $trackerRepository->findByDateRange($habit, $user, $startDate, $endDate);
            
            $habitData = [
                'habit' => $habit,
                'values' => [],
            ];
            
            foreach ($trackers as $tracker) {
                $habitData['values'][$tracker->getDate()->format('Y-m-d')] = [
                    'value' => $tracker->getValue(),
                    'points' => $tracker->getPoints(),
                ];
            }
            
            $trackerData[$habit->getId()] = $habitData;
        }
        
        return $trackerData;
    }

    public function trackHabit(Habit $habit, User $user, float $value, \DateTime $date = null): Tracker
    {
        $date = $date ?? new \DateTime('today');
        
        $trackerRepository = $this->entityManager->getRepository(Tracker::class);
        $tracker = $trackerRepository->findOneBy([
            'habit' => $habit,
            'user' => $user,
            'date' => $date,
        ]);
        
        if (!$tracker) {
            $tracker = new Tracker();
            $tracker->setHabit($habit);
            $tracker->setUser($user);
            $tracker->setDate($date);
        }
        
        $tracker->setValue($value);
        
        // Calculate points based on habit settings
        $points = $this->calculatePoints($habit, $value);
        $tracker->setPoints($points);
        
        $this->entityManager->persist($tracker);
        $this->entityManager->flush();
        
        return $tracker;
    }

    private function calculatePoints(Habit $habit, float $value): float
    {
        // If habit is productive, points are positive, otherwise negative
        $multiplier = $habit->isProductive() ? 1 : -1;
        
        // Base points from habit configuration
        $basePoints = $habit->getPoints();
        
        // For boolean habits (done/not done)
        if ($habit->getValueType() === 'boolean') {
            return $value > 0 ? $basePoints * $multiplier : 0;
        }
        
        // For numeric habits, points are proportional to the value
        // but must meet minimum value requirement
        if ($value >= $habit->getMinValue()) {
            return $basePoints * $value * $multiplier;
        }
        
        return 0;
    }
} 