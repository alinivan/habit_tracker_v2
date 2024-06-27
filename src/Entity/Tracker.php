<?php

namespace App\Entity;

use App\Repository\TrackerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackerRepository::class)]
class Tracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $habit_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $value = null;

    #[ORM\Column]
    private ?int $routine_category_id = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
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
}
