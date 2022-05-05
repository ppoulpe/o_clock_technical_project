<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ScoreToRegister;
use App\Dto\ScoreToShow;
use App\Entity\Score;
use App\Service\LeaderBoardManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\RequestBody;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1.0/leaderboard', name: 'leaderboard_')]
class LeaderBoardController extends AbstractController
{
    #[Route('/', name: 'register', methods: ['POST'])]
    #[RequestBody(
        description: 'User score to register in leaderboard',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'username', type: 'string'),
                new OA\Property(property: 'score', type: 'float'),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'User score inserted in leaderboard if success.',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(type: ScoreToShow::class)
            )
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid payload. Return an array of constraint violations list.',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                type: 'array',
                items: new OA\Items(
                    type: 'string'
                )
            )
        )
    )]
    public function registerUserScore(
        Request $request,
        LeaderBoardManager $leaderBoardManager,
        ValidatorInterface $validator
    ): JsonResponse {
        $userScoreToRegister = ScoreToRegister::fromRequest($request);
        $errors = $validator->validate($userScoreToRegister);

        if ($errors->count() > 0) {
            $messages = [];

            /** @var ConstraintViolation $constraintViolation */
            foreach ($errors as $constraintViolation) {
                $messages[] = $constraintViolation->getPropertyPath().': '.$constraintViolation->getMessage();
            }

            return $this->json(
                $messages,
                Response::HTTP_BAD_REQUEST
            );
        }

        $registeredUserScore = $leaderBoardManager->registerUserScore(
            $userScoreToRegister->username,
            $userScoreToRegister->score,
        );

        return $this->json(
            ScoreToShow::fromEntity($registeredUserScore),
            Response::HTTP_CREATED
        );
    }

    #[Route('/', name: 'show', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Leaderboard informations.',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                type: 'array',
                items: new OA\Items(
                    ref: new Model(type: ScoreToShow::class)
                )
            )
        )
    )]
    public function showLeaderBoard(LeaderBoardManager $leaderBoardManager): JsonResponse
    {
        return $this->json(
            // On va changer toutes les entités en DTO que l'on va pouvoir exposer vers l'exterieur
            array_map(
                static fn (Score $score): ScoreToShow => ScoreToShow::fromEntity($score),
                $leaderBoardManager->getLeaderBoardScores()
            ),
            Response::HTTP_OK
        );
    }
}
