<?php

namespace App\Service;

use App\Entity\Habit;
use App\Entity\Tracker;
use Doctrine\ORM\EntityManagerInterface;

class ChartService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createHabitChart(Habit $habit): array
    {
        $trackerRepository = $this->entityManager->getRepository(Tracker::class);
        $trackerData = $trackerRepository->findBy(['habit' => $habit], ['date' => 'ASC']);

        $labels = [];
        $values = [];

        foreach ($trackerData as $tracker) {
            $labels[] = $tracker->getDate()->format('Y-m-d');
            $values[] = $tracker->getValue();
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
} 