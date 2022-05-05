<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

final class ScoreToRegister
{
    #[NotBlank, NotNull, Type(type: 'string'), Length(min: 3, max: 50)]
    #[Property(type: 'string')]
    public readonly mixed $username;

    #[NotBlank, NotNull, Type(type: 'int'), GreaterThan(1)]
    #[Property(type: 'integer')]
    public readonly mixed $score;

    public function __construct(
        mixed $username,
        mixed $score
    ) {
        $this->username = $username;
        $this->score = $score;
    }

    public static function fromRequest(Request $request): self
    {
        $flatDataFromRequest = json_decode(
            $request->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return new self(
            $flatDataFromRequest['username'],
            // On récupère la valeur en int, plus facilement manipulable que des floats
            // On cast une première fois pour prendre en compte le cas d'une mauvaise donnée
            // On cast une seconde fois pour pouvoir convertir le float en int pour le stockage
            (int) ((float) $flatDataFromRequest['score'] * 100)
        );
    }
}
