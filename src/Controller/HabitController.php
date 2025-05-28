<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Habit;
use App\Form\HabitType;
use App\Service\ChartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/habits')]
class HabitController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ChartBuilderInterface $chartBuilder,
        private readonly ChartService $chartService
    ) {
    }

    #[Route('/', name: 'app_habit_index', methods: ['GET'])]
    public function index(): Response
    {
        $habits = $this->entityManager->getRepository(Habit::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('habit/index.html.twig', [
            'habits' => $habits,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'app_habit_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $habit = new Habit();
        $habit->setUser($this->getUser());
        
        $form = $this->createForm(HabitType::class, $habit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($habit);
            $this->entityManager->flush();

            $this->addFlash('success', 'Habit created successfully.');
            return $this->redirectToRoute('app_habit_index');
        }

        return $this->render('habit/new.html.twig', [
            'habit' => $habit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_habit_show', methods: ['GET'])]
    public function show(Habit $habit): Response
    {
        return $this->render('habit/show.html.twig', [
            'habit' => $habit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_habit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habit $habit): Response
    {
        $form = $this->createForm(HabitType::class, $habit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Habit updated successfully.');
            return $this->redirectToRoute('app_habit_index');
        }

        // Create chart
        $dataset = $this->chartService->createHabitChart($habit);
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $dataset['labels'],
            'datasets' => [
                [
                    'label' => $habit->getName(),
                    'data' => $dataset['values'],
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ]
            ]
        ]);

        return $this->render('habit/edit.html.twig', [
            'habit' => $habit,
            'form' => $form,
            'chart' => $chart,
        ]);
    }

    #[Route('/{id}', name: 'app_habit_delete', methods: ['POST'])]
    public function delete(Request $request, Habit $habit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habit->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($habit);
            $this->entityManager->flush();
            
            $this->addFlash('success', 'Habit deleted successfully.');
        }

        return $this->redirectToRoute('app_habit_index');
    }
} 