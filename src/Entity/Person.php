<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $middlename = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 20)]
    private ?string $barrau = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Candidacy::class)]
    private Collection $candidacies;

    public function __construct()
    {
        $this->candidacies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

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

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(?string $middlename): static
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getBarrau(): ?string
    {
        return $this->barrau;
    }

    public function setBarrau(string $barrau): static
    {
        $this->barrau = $barrau;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Candidacy>
     */
    public function getCandidacies(): Collection
    {
        return $this->candidacies;
    }

    public function addCandidacy(Candidacy $candidacy): static
    {
        if (!$this->candidacies->contains($candidacy)) {
            $this->candidacies->add($candidacy);
            $candidacy->setPerson($this);
        }

        return $this;
    }

    public function removeCandidacy(Candidacy $candidacy): static
    {
        if ($this->candidacies->removeElement($candidacy)) {
            // set the owning side to null (unless already changed)
            if ($candidacy->getPerson() === $this) {
                $candidacy->setPerson(null);
            }
        }

        return $this;
    }
}
