<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $year = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'publication')]
    private Collection $media;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarBrand $brand = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarModel $model = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MotorizationType $motorizationType = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private $imageFilenames = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private $videoFilename;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setPublication($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getPublication() === $this) {
                $medium->setPublication(null);
            }
        }

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

    public function getBrand(): ?CarBrand
    {
        return $this->brand;
    }
    
    public function setBrand(?CarBrand $brand): static
    {
        $this->brand = $brand;
    
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
    
    public function getMotorizationType(): ?MotorizationType
    {
        return $this->motorizationType;
    }
    
    public function setMotorizationType(?MotorizationType $motorizationType): static
    {
        $this->motorizationType = $motorizationType;
    
        return $this;
    }

    public function getImageFilenames(): ?array
    {
        return $this->imageFilenames;
    }

    public function setImageFilenames(?array $imageFilenames): self
    {
        $this->imageFilenames = $imageFilenames;

        return $this;
    }

    public function addImageFilename(string $imageFilename): self
    {
        $this->imageFilenames[] = $imageFilename;

        return $this;
    }

    public function getVideoFilename(): ?string
    {
        return $this->videoFilename;
    }

    public function setVideoFilename(?string $videoFilename): self
    {
        $this->videoFilename = $videoFilename;

        return $this;
    }
    
}
