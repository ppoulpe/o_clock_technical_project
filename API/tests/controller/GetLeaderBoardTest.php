<?php

namespace App\Tests\controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetLeaderBoardTest extends WebTestCase
{
    public function testGetUserScoreWithoutApiToken(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'https://localhost/api/v1.0/leaderboard');

        self::assertEquals(
            '{"code":0,"message":"Full authentication is required to access this resource."}',
            $crawler->text()
        );
        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetLeaderBoardWithApiToken(): void
    {
        $client = static::createClient();
        $client->jsonRequest(
            'GET',
            'https://localhost/api/v1.0/leaderboard',
            [],
            ['HTTP_x-api-key' => 'MY_AWESOME_APP']
        );

        $responseToAssert = json_decode(
            $client->getResponse()->getContent(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        // La requête retourne un code HTTP 200 (OK)
        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        // On a bien les trois éléments de la base qui remontent
        self::assertCount(3, $responseToAssert);

        // On prend un élément dans la réponse qu'on va tester
        self::assertEquals('jerome.dumas', $responseToAssert[0]->username);
        self::assertEquals(18.76, $responseToAssert[0]->score);

        self::assertEquals(
            (new DateTime())->format('d/m/Y'),
            (new DateTime($responseToAssert[0]->createdAt->date))->format('d/m/Y')
        );

        self::assertEquals(
            (new DateTime())->format('d/m/Y'),
            (new DateTime($responseToAssert[0]->updatedAt->date))->format('d/m/Y')
        );
    }

    public function testGetLeaderBoardWithLimit(): void
    {
        $client = static::createClient();
        $client->jsonRequest(
            'GET',
            'https://localhost/api/v1.0/leaderboard?limit=2',
            [],
            ['HTTP_x-api-key' => 'MY_AWESOME_APP']
        );

        $responseToAssert = json_decode(
            $client->getResponse()->getContent(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        // La requête retourne un code HTTP 200 (OK)
        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        // On a bien les trois éléments de la base qui remontent
        self::assertCount(2, $responseToAssert);
    }
}
