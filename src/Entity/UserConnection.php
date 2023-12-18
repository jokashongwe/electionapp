<?php

namespace App\Entity;

use App\Repository\UserConnectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserConnectionRepository::class)]
class UserConnection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userConnections')]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $connexionDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $suspect = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getConnexionDate(): ?\DateTimeInterface
    {
        return $this->connexionDate;
    }

    public function setConnexionDate(?\DateTimeInterface $connexionDate): static
    {
        $this->connexionDate = $connexionDate;

        return $this;
    }

    public function isSuspect(): ?bool
    {
        return $this->suspect;
    }

    public function setSuspect(?bool $suspect): static
    {
        $this->suspect = $suspect;

        return $this;
    }
}
