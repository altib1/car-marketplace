<?php

namespace App\Entity;

use App\Repository\WishlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WishlistRepository::class)]
class Wishlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'wishlist', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\ManyToMany(targetEntity: Publication::class)]
    #[ORM\JoinTable(name: 'wishlist_publications')]
    private Collection $publications;

    public function __construct()
    {
        $this->publications= new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

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
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        $this->publications->removeElement($publication);
        return $this;
    }

    public function hasPublication(Publication $publication): bool
    {
        return $this->publications->contains($publication);
    }
}
