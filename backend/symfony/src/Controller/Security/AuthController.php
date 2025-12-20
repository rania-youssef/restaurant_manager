<?php

namespace App\Controller\Security;

use App\Repository\Security\UserRepository;
use App\Security\JwtService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JwtService $jwtService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // 1️⃣ Validation basique
        if (
            empty($data['email']) ||
            empty($data['password'])
        ) {
            return $this->json([
                'error' => 'Email and password are required'
            ], 400);
        }

        $user = $userRepository->findOneBy([
            'email' => $data['email']
        ]);

        if (!$user) {
            return $this->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        if (!$passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        $token = $jwtService->generate([
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);

        return $this->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ]);
    }
}
