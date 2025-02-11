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

    #[ORM\ManyToOne(inversedBy: 'publications')]
    private ?Shop $shop = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarBrand $brand = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarModel $model = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MotorizationType $motorizationType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private $imageFilenames = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private $videoFilename;

    #[ORM\Column(nullable: true)]
    private ?int $mileage = null;

    #[ORM\Column(length: 50)]
    private ?string $fuelType = null;

    #[ORM\Column(length: 50)]
    private ?string $gearbox = null;

    #[ORM\Column]
    private ?bool $hasWarranty = null;

    #[ORM\Column(nullable: true)]
    private ?int $warrantyMonths = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $sellerLocation = null;

    #[ORM\Column(name: 'vehicle_condition', type: Types::STRING, length: 255)]
    private ?string $condition = null;

    #[ORM\Column(name: 'vehicle_equipment', type: Types::JSON, nullable: true)]
    private array $equipment = [];

    #[ORM\Column(nullable: true)]
    private ?float $engineSize = null;

    #[ORM\ManyToMany(targetEntity: Wishlist::class, mappedBy: 'publications')]
    private Collection $wishlists;

    #[ORM\OneToOne(mappedBy: 'publication', targetEntity: SaleStatus::class, cascade: ['persist', 'remove'])]
    private ?SaleStatus $saleStatus = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isImport = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?ImportCountry $importCountry = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isCustomsDutyPaid = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $importDetails = null;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        $this->shop = $shop;

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

        public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(?int $mileage): self
    {
        $this->mileage = $mileage;
        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(?string $fuelType): self
    {
        $this->fuelType = $fuelType;
        return $this;
    }

    public function getEngineSize(): ?float
    {
        return $this->engineSize;
    }

    public function setEngineSize(?float $engineSize): self
    {
        $this->engineSize = $engineSize;
        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(?string $gearbox): self
    {
        $this->gearbox = $gearbox;
        return $this;
    }

    public function getHasWarranty(): ?bool
    {
        return $this->hasWarranty;
    }

    public function setHasWarranty(bool $hasWarranty): self
    {
        $this->hasWarranty = $hasWarranty;
        return $this;
    }

    public function getWarrantyMonths(): ?int
    {
        return $this->warrantyMonths;
    }

    public function setWarrantyMonths(?int $warrantyMonths): self
    {
        $this->warrantyMonths = $warrantyMonths;
        return $this;
    }

    public function getSellerLocation(): ?Region
    {
        return $this->sellerLocation;
    }

    public function setSellerLocation(?Region $sellerLocation): self
    {
        $this->sellerLocation = $sellerLocation;
        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    public function getEquipment(): array
    {
        return $this->equipment;
    }

    public function setEquipment(?array $equipment): self
    {
        $this->equipment = $equipment;
        return $this;
    }

    public function addEquipment(string $item): self
    {
        if (!in_array($item, $this->equipment)) {
            $this->equipment[] = $item;
        }
        return $this;
    }

    public function removeEquipment(string $item): self
    {
        $key = array_search($item, $this->equipment);
        if ($key !== false) {
            unset($this->equipment[$key]);
            $this->equipment = array_values($this->equipment);
        }
        return $this;
    }
    /**
     * @return Collection<int, Wishlist>
     */
    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function addWishlist(Wishlist $wishlist): static
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists->add($wishlist);
            $wishlist->addPublication($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): static
    {
        if ($this->wishlists->removeElement($wishlist)) {
            $wishlist->removePublication($this);
        }

        return $this;
    }

    public function getSaleStatus(): ?SaleStatus
    {
        return $this->saleStatus;
    }

    public function setSaleStatus(?SaleStatus $saleStatus): self
    {
        if ($saleStatus !== null && $saleStatus->getPublication() !== $this) {
            $saleStatus->setPublication($this);
        }

        $this->saleStatus = $saleStatus;

        return $this;
    }

    public function isImport(): bool
    {
        return $this->isImport;
    }

    public function setIsImport(bool $isImport): self
    {
        $this->isImport = $isImport;
        return $this;
    }

    public function getImportCountry(): ?ImportCountry
    {
        return $this->importCountry;
    }

    public function setImportCountry(?ImportCountry $importCountry): self
    {
        $this->importCountry = $importCountry;
        return $this;
    }

    public function isCustomsDutyPaid(): ?bool
    {
        return $this->isCustomsDutyPaid;
    }

    public function setIsCustomsDutyPaid(?bool $isCustomsDutyPaid): self
    {
        $this->isCustomsDutyPaid = $isCustomsDutyPaid;
        return $this;
    }

    public function getImportDetails(): ?string
    {
        return $this->importDetails;
    }

    public function setImportDetails(?string $importDetails): self
    {
        $this->importDetails = $importDetails;
        return $this;
    }
    
}
