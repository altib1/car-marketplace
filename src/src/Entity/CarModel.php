<?php

namespace App\Entity;

use App\Repository\CarModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarModelRepository::class)]
class CarModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'carModels')]
    private ?CarBrand $brand = null;

    /**
     * @var Collection<int, MotorizationType>
     */
    #[ORM\OneToMany(targetEntity: MotorizationType::class, mappedBy: 'model')]
    private Collection $motorizationTypes;

    public function __construct()
    {
        $this->motorizationTypes = new ArrayCollection();
    }

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

    public function getBrand(): ?CarBrand
    {
        return $this->brand;
    }

    public function setBrand(?CarBrand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, MotorizationType>
     */
    public function getMotorizationTypes(): Collection
    {
        return $this->motorizationTypes;
    }

    public function addMotorizationType(MotorizationType $motorizationType): static
    {
        if (!$this->motorizationTypes->contains($motorizationType)) {
            $this->motorizationTypes->add($motorizationType);
            $motorizationType->setModel($this);
        }

        return $this;
    }

    public function removeMotorizationType(MotorizationType $motorizationType): static
    {
        if ($this->motorizationTypes->removeElement($motorizationType)) {
            // set the owning side to null (unless already changed)
            if ($motorizationType->getModel() === $this) {
                $motorizationType->setModel(null);
            }
        }

        return $this;
    }
}
