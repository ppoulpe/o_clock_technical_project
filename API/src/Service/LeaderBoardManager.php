<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Score;
use App\Repository\LeaderBoardRepository;

class LeaderBoardManager
{
    public function __construct(private readonly LeaderBoardRepository $leaderBoardRepository) {}

    public function registerUserScore(
        string $username,
        int $score
    ): Score
    {
        // On va changer notre DTO par une entité qui sera ensuite persisté puis flushé par Doctrine
        $userScoreEntity = (new Score())
            ->setUsername($username)
            ->setScore($score);

        // Pas de magie, le add est une méthode générée par le MakerBundle qui va faire deux choses essentielles :
        // 1 - persist, charge en mémoire et indique à Doctrine les opérations qu'il va devoir faire.
        // C'est à ce moment que sont résolu les uuid et les dates dans notre cas.

        // 2 - flush, comme son nom l'indique, envoi tout ce qui a été précédement persisté en base.
        // C'est à ce moment que le SQL est joué "pour de vrai"
        $this
            ->leaderBoardRepository
            ->add($userScoreEntity);

        // On retourne l'entité persisté, pour la retourner au client qui pourra, par exemple,
        // modifier le DOM avec cette nouvelle donnée
        return $userScoreEntity;
    }

    /**
     * @return array<Score>
     */
    public function getLeaderBoardScores(?int $limit = null): array
    {
        // Je retourne tous les scores du leaderboard
        return $this
            ->leaderBoardRepository
            ->findBy(
                [], ['score' => 'ASC'], $limit, 0
            );
    }
}
