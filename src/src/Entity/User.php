<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Publication>
     */
    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'user')]
    private Collection $publications;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\OneToOne(mappedBy: 'User', cascade: ['persist', 'remove'])]
    private ?Wishlist $wishlist = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Shop $shop = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Conversation::class)]
    private Collection $sentConversations;

    #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Conversation::class)]
    private Collection $receivedConversations;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->sentConversations = new ArrayCollection();
        $this->receivedConversations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $publication->setUser($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getUser() === $this) {
                $publication->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getWishlist(): ?Wishlist
    {
        return $this->wishlist;
    }

    public function setWishlist(?Wishlist $wishlist): static
    {
        // unset the owning side of the relation if necessary
        if ($wishlist === null && $this->wishlist !== null) {
            $this->wishlist->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($wishlist !== null && $wishlist->getUser() !== $this) {
            $wishlist->setUser($this);
        }

        $this->wishlist = $wishlist;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        // unset the owning side of the relation if necessary
        if ($shop === null && $this->shop !== null) {
            $this->shop->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($shop !== null && $shop->getUser() !== $this) {
            $shop->setUser($this);
        }

        $this->shop = $shop;

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getSentConversations(): Collection
    {
        return $this->sentConversations;
    }

    public function addSentConversation(Conversation $sentConversation): static
    {
        if (!$this->sentConversations->contains($sentConversation)) {
            $this->sentConversations->add($sentConversation);
            $sentConversation->setSender($this);
        }

        return $this;
    }

    public function removeSentConversation(Conversation $sentConversation): static
    {
        if ($this->sentConversations->removeElement($sentConversation)) {
            // set the owning side to null (unless already changed)
            if ($sentConversation->getSender() === $this) {
                $sentConversation->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getReceivedConversations(): Collection
    {
        return $this->receivedConversations;
    }

    public function addReceivedConversation(Conversation $receivedConversation): static
    {
        if (!$this->receivedConversations->contains($receivedConversation)) {
            $this->receivedConversations->add($receivedConversation);
            $receivedConversation->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedConversation(Conversation $receivedConversation): static
    {
        if ($this->receivedConversations->removeElement($receivedConversation)) {
            // set the owning side to null (unless already changed)
            if ($receivedConversation->getRecipient() === $this) {
                $receivedConversation->setRecipient(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name . ' ' . $this->lastname;
    }
    
}
