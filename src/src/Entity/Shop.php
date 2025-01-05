<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?string $backgroundImageFileName = null;

    #[ORM\Column]
    private ?string $logoImageFileName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?array $services = null;

    #[ORM\Column(length: 255)]
    private ?string $workHours = null;

    #[ORM\OneToOne(inversedBy: 'shop', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Publication>
     */
    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'shop')]
    private Collection $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
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

    public function getBackgroundImageFileName(): ?string
    {
        return $this->backgroundImageFileName;
    }

    public function setBackgroundImageFileName(?string $backgroundImageFileName): static
    {
        $this->backgroundImageFileName = $backgroundImageFileName;

        return $this;
    }

    public function getLogoImageFileName(): ?string
    {
        return $this->logoImageFileName;
    }

    public function setLogoImageFileName(string $logoImageFileName): static
    {
        $this->logoImageFileName = $logoImageFileName;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getServices(): ?array
    {
        return $this->services;
    }

    public function setServices(?array $services): static
    {
        $this->services = $services;

        return $this;
    }

    public function getWorkHours(): ?string
    {
        return $this->workHours;
    }

    public function setWorkHours(string $workHours): static
    {
        $this->workHours = $workHours;

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

        /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setShop($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getShop() === $this) {
                $publication->setShop(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
