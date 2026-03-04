<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\Auth\LoginCommand;
use App\Application\Auth\LoginHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController
{
    public function __construct(
        private LoginHandler $loginHandler
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
            'message' => 'Login successful'
        ]);
    }
}
