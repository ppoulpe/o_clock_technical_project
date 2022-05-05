<?php

namespace App\Tests\controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostLeaderBoardTest extends WebTestCase
{
    public function testPostUserScoreWithoutApiToken(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', 'https://localhost/api/v1.0/leaderboard/');

        self::assertEquals(
            '{"code":0,"message":"Full authentication is required to access this resource."}',
            $crawler->text()
        );
        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testPostUserScoreWithApiToken(): void
    {
        $score = [
            'username' => 'johnny.bravo',
            'score' => 23.1,
        ];

        $client = static::createClient();
        $client->jsonRequest(
            'POST',
            'https://localhost/api/v1.0/leaderboard/',
            $score,
            ['HTTP_x-api-key' => 'MY_AWESOME_APP']
        );

        $responseToAssert = json_decode(
            $client->getResponse()->getContent(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertEquals('johnny.bravo', $responseToAssert->username);
        self::assertEquals(23.1, $responseToAssert->score);
        self::assertEquals(
            (new DateTime())->format('d/m/Y'),
            (new DateTime($responseToAssert->createdAt->date))->format('d/m/Y')
        );
    }

    public function testPostUserScoreWithUnvalidPayload(): void
    {
        $score = [
            'username' => 'j',
            'score' => 'ff',
        ];

        $client = static::createClient();
        $client->jsonRequest(
            'POST',
            'https://localhost/api/v1.0/leaderboard/',
            $score,
            ['HTTP_x-api-key' => 'MY_AWESOME_APP']
        );

        $responseToAssert = json_decode(
            $client->getResponse()->getContent(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        self::assertEquals(
            [
                "username: This value is too short. It should have 3 characters or more.",
                "score: This value should be greater than 1.",
            ],
            $responseToAssert
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
