<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Habit;
use App\Entity\Tracker;
use App\Service\DashboardService;
use App\Service\TrackerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DashboardService $dashboardService,
        private readonly TrackerService $trackerService
    ) {
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $categories = $this->entityManager->getRepository(Category::class)->findAllWithHabitsByUser($user);
        $habitsValues = $this->dashboardService->getHabitsValuesForToday($user);
        
        // Get dashboard stats
        $stats = $this->getDashboardStats();
        
        // Get tracker data for the current period
        $trackerData = $this->trackerService->getTrackerDataForCurrentPeriod($user);

        return $this->render('dashboard/index.html.twig', [
            'categories' => $categories,
            'habits_values' => $habitsValues,
            'stats' => $stats,
            'tracker_data' => $trackerData,
        ]);
    }

    private function getDashboardStats(): array
    {
        $user = $this->getUser();
        $trackerRepository = $this->entityManager->getRepository(Tracker::class);
        
        // Get productive minutes for today
        $productiveMinutes = $trackerRepository->getSumOfTodayProductiveMinutes($user);
        $productiveHours = round($productiveMinutes / 60, 2);
        
        // Get today's start hour
        $todayStartHour = $trackerRepository->getTodayStartHour($user);
        
        // Calculate average points for last 7 days
        $pointsLast7Days = $trackerRepository->getSumOfPointsLast7Days($user);
        $averageDailyPoints = round($pointsLast7Days / 7, 2);
        
        // Get weight tracking if available
        $weightHabit = $this->entityManager->getRepository(Habit::class)->findOneBy([
            'user' => $user,
            'measurement' => 'kg'
        ]);
        $lastWeight = $weightHabit ? $trackerRepository->getLastValueForHabit($weightHabit) : null;

        return [
            'productive_hours' => $productiveHours,
            'start_hour' => $todayStartHour,
            'average_points' => $averageDailyPoints,
            'last_weight' => $lastWeight,
        ];
    }
} 