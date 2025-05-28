<?php

namespace App\Entity;

use App\Repository\HabitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitRepository::class)]
#[ORM\Table(name: 'habits')]
class Habit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $value_type = null;

    #[ORM\ManyToOne(inversedBy: 'habits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(nullable: true)]
    private ?float $min_value = null;

    #[ORM\Column]
    private ?int $order = null;

    #[ORM\Column]
    private ?bool $active = true;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $measurement = null;

    #[ORM\Column]
    private ?bool $is_productive = false;

    #[ORM\Column]
    private ?int $points = 0;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parent = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getValueType(): ?string
    {
        return $this->value_type;
    }

    public function setValueType(string $value_type): static
    {
        $this->value_type = $value_type;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getMinValue(): ?float
    {
        return $this->min_value;
    }

    public function setMinValue(?float $min_value): static
    {
        $this->min_value = $min_value;
        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(int $order): static
    {
        $this->order = $order;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;
        return $this;
    }

    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }

    public function setMeasurement(?string $measurement): static
    {
        $this->measurement = $measurement;
        return $this;
    }

    public function isProductive(): ?bool
    {
        return $this->is_productive;
    }

    public function setIsProductive(bool $is_productive): static
    {
        $this->is_productive = $is_productive;
        return $this;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
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
} 