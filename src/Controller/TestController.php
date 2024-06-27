<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\HabitsRepository;
use App\Repository\RoutineCategoryRepository;
use App\Repository\RoutineRepository;
use App\Repository\TaskRepository;
use App\Repository\TrackerRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(
        CategoryRepository $categoryRepository,
        HabitsRepository $habitsRepository,
        RoutineCategoryRepository $routineCategoryRepository,
        RoutineRepository $routineRepository,
        TaskRepository $taskRepository,
        TrackerRepository $trackerRepository,
        UsersRepository $usersRepository
    ): Response
    {
        dd($usersRepository->findAll());
    }
}
