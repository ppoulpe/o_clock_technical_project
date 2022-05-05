<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Score;
use DateTimeImmutable;

final class ScoreToShow
{
    public function __construct(
        public readonly string $username,
        public readonly float $score,
        public readonly DateTimeImmutable $createdAt
    ) {
    }

    public static function fromEntity(Score $score): self
    {
        return new self(
            $score->getUsername(),
            $score->getScore() / 100,
            $score->getCreatedAt(),
        );
    }
}
