<?php

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoutineRepository::class)]
class Routine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $routine_category_id = null;

    #[ORM\Column]
    private ?int $habit_id = null;

    #[ORM\Column]
    private ?int $target_value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoutineCategoryId(): ?int
    {
        return $this->routine_category_id;
    }

    public function setRoutineCategoryId(int $routine_category_id): static
    {
        $this->routine_category_id = $routine_category_id;

        return $this;
    }

    public function getHabitId(): ?int
    {
        return $this->habit_id;
    }

    public function setHabitId(int $habit_id): static
    {
        $this->habit_id = $habit_id;

        return $this;
    }

    public function getTargetValue(): ?int
    {
        return $this->target_value;
    }

    public function setTargetValue(int $target_value): static
    {
        $this->target_value = $target_value;

        return $this;
    }
}
