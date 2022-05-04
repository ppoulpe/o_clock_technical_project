<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('x-api-key');
    }

    public function authenticate(Request $request): Passport
    {
        // Si le client n'envoi aucune clef d'API, on lui envoi une erreur sympathique du type :
        // Merci de nous fournir une clef d'API
        if (null === $apiKey = $request->headers->get('x-api-key')) {
            throw new CustomUserMessageAuthenticationException('Missing API Key');
        }

        /**
         * Aucune restriction particulière, notre API est publique
         *
         * Pour aller plus loin : création d'un compte et association d'une clef / compte
         * pour autoriser uniquement les utilisateurs enregistrés
         */
        return new SelfValidatingPassport(
            new UserBadge($apiKey, fn() => new PublicApiUser($apiKey))
        );
    }

    /**
     * Si l'utilisateur a réussi à s'authentifier, on le laisse passer.
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response
    {
        return null;
    }

    /**
     * Si la clef d'API n'est pas bonne : on renvoi un JSON avec le code 401 (Non autorisé)
     * On en profite pour indiquer à l'utilisateur qu'il a tout simplement donner de mauvais identifiants (ici la clef d'API)
     */
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): ?Response
    {
        return new JsonResponse(
            [
                'key' => $exception->getMessageKey(),
                'message' => $exception->getMessageData(),
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

}
