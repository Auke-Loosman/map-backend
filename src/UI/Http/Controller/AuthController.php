<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\Auth\LoginCommand;
use App\Application\Auth\LoginHandler;
use App\Application\Auth\RegisterCommand;
use App\Application\Auth\RegisterHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController
{
    public function __construct(
        private LoginHandler $loginHandler,
        private RegisterHandler $registerHandler
    ) {}

    #[Route('/api/login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new LoginCommand(
            $data['email'],
            $data['password']
        );

        $user = $this->loginHandler->handle($command);

        return new JsonResponse([
            'token' => 'dummy-token',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail()
            ]
        ]);
    }

    #[Route('/api/register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new RegisterCommand(
            $data['email'],
            $data['password']
        );

        $user = $this->registerHandler->handle($command);

        return new JsonResponse([
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail()
            ]
        ], 201);
    }
}
