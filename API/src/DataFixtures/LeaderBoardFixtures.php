<?php

namespace App\DataFixtures;

use App\Entity\Score;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LeaderBoardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->resolveFixtures() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function resolveFixtures(): iterable
    {
        yield (new Score())->setUsername('john.doe')->setScore(4367);
        yield (new Score())->setUsername('jane.doe')->setScore(6535);
        yield (new Score())->setUsername('jerome.dumas')->setScore(1876)->setUpdatedAt();
    }
}
