<?php

namespace App\Entity;

use App\Repository\HabitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitsRepository::class)]
class Habits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $value_type = null;

    #[ORM\Column]
    private ?int $category_id = null;

    #[ORM\Column]
    private ?int $min_value = null;

    #[ORM\Column]
    private ?int $active = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_productive = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(name: 'order')]
    private ?int $order_no = null;

    #[ORM\Column(length: 255)]
    private ?string $measurement = null;

    #[ORM\Column]
    private ?int $parent_id = null;

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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

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

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getMinValue(): ?int
    {
        return $this->min_value;
    }

    public function setMinValue(int $min_value): static
    {
        $this->min_value = $min_value;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function isProductive(): ?bool
    {
        return $this->is_productive;
    }

    public function setProductive(?bool $is_productive): static
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

    public function getOrderNo(): ?int
    {
        return $this->order_no;
    }

    public function setOrderNo(int $order_no): static
    {
        $this->order_no = $order_no;

        return $this;
    }

    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }

    public function setMeasurement(string $measurement): static
    {
        $this->measurement = $measurement;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(int $parent_id): static
    {
        $this->parent_id = $parent_id;

        return $this;
    }
}
