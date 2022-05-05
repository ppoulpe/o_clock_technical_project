<?php

namespace App\Entity;

use App\Repository\LeaderBoardRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[
    ORM\Entity(repositoryClass: LeaderBoardRepository::class),
    ORM\Table(name: 'leaderboard'),
    ORM\HasLifecycleCallbacks
]
class Score
{
    #[
        ORM\Id,
        ORM\Column(type: 'uuid', unique: true),
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(class: UuidGenerator::class)
    ]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $updated_at;

    #[ORM\Column(type: 'integer')]
    private int $score;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->created_at = new DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updated_at = new DateTime();

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
