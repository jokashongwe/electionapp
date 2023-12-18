<?php

namespace App\Entity;

use App\Repository\UserVoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserVoteRepository::class)]
class UserVote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userVotes')]
    private ?User $voter = null;

    #[ORM\ManyToOne(inversedBy: 'userVotes')]
    private ?Vote $vote = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $voteDate = null;

    #[ORM\ManyToOne(inversedBy: 'userVotes')]
    private ?Candidacy $candidate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoter(): ?User
    {
        return $this->voter;
    }

    public function setVoter(?User $voter): static
    {
        $this->voter = $voter;

        return $this;
    }

    public function getVote(): ?Vote
    {
        return $this->vote;
    }

    public function setVote(?Vote $vote): static
    {
        $this->vote = $vote;

        return $this;
    }

    public function getVoteDate(): ?\DateTimeInterface
    {
        return $this->voteDate;
    }

    public function setVoteDate(\DateTimeInterface $voteDate): static
    {
        $this->voteDate = $voteDate;

        return $this;
    }

    public function getCandidate(): ?Candidacy
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidacy $candidate): static
    {
        $this->candidate = $candidate;

        return $this;
    }
}
