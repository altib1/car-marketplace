<?php

namespace App\Entity;

use App\Repository\MotorizationTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotorizationTypeRepository::class)]
class MotorizationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'motorizationTypes')]
    private ?CarModel $model = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    public function setModel(?CarModel $model): static
    {
        $this->model = $model;

        return $this;
    }
}
