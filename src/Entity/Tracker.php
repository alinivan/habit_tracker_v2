<?php

namespace App\Entity;

use App\Repository\TrackerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Habit::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habit $habit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $value = null;

    #[ORM\ManyToOne(targetEntity: RoutineCategory::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?RoutineCategory $routineCategory = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $points = 0;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabit(): ?Habit
    {
        return $this->habit;
    }

    public function setHabit(?Habit $habit): static
    {
        $this->habit = $habit;
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

    public function getRoutineCategory(): ?RoutineCategory
    {
        return $this->routineCategory;
    }

    public function setRoutineCategory(?RoutineCategory $routineCategory): static
    {
        $this->routineCategory = $routineCategory;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;
        return $this;
    }

    #[ORM\PrePersist]
    public function calculatePoints(): void
    {
        if ($this->habit && $this->habit->isProductive()) {
            $this->points = $this->habit->getPoints();
        } else {
            $this->points = 0;
        }
    }
}
