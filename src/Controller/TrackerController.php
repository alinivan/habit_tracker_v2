<?php

namespace App\Controller;

use App\Entity\Habit;
use App\Service\TrackerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tracker')]
class TrackerController extends AbstractController
{
    public function __construct(
        private readonly TrackerService $trackerService
    ) {
    }

    #[Route('/track/{id}', name: 'app_tracker_track', methods: ['POST'])]
    public function track(Request $request, Habit $habit): JsonResponse
    {
        $value = $request->request->get('value');
        $date = $request->request->get('date') ? new \DateTime($request->request->get('date')) : null;

        if ($value === null) {
            return new JsonResponse(['error' => 'Value is required'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $tracker = $this->trackerService->trackHabit($habit, $this->getUser(), (float)$value, $date);
            
            return new JsonResponse([
                'success' => true,
                'tracker' => [
                    'id' => $tracker->getId(),
                    'value' => $tracker->getValue(),
                    'points' => $tracker->getPoints(),
                    'date' => $tracker->getDate()->format('Y-m-d'),
                ]
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/history/{id}', name: 'app_tracker_history', methods: ['GET'])]
    public function history(Habit $habit): Response
    {
        $trackerData = $this->trackerService->getTrackerDataForCurrentPeriod($this->getUser());
        $habitData = $trackerData[$habit->getId()] ?? ['values' => []];

        return $this->render('tracker/history.html.twig', [
            'habit' => $habit,
            'tracker_data' => $habitData['values'],
        ]);
    }
} 