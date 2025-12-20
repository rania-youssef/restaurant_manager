<?php

namespace App\Security;

use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private \App\Security\JwtService $jwtService,
        private UserProviderInterface $userProvider
    ) {}

    public function supports(Request $request): ?bool
    {
        return str_starts_with($request->getPathInfo(), '/back-office')
            && $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
        $payload = $this->jwtService->validate($token);

        if (!$payload) {
            throw new AuthenticationException('Invalid token');
        }

        return new SelfValidatingPassport(
            new UserBadge($payload['email'], fn () =>
                $this->userProvider->loadUserByIdentifier($payload['email'])
            )
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?JsonResponse
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        return new JsonResponse(['error' => 'Unauthorized'], 401);
    }
}
