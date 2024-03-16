<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_create', methods: 'POST')]
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $request->toArray();
        $user = new Users();
        $hashedPassworn = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setEmail($data['email']);
        $user->setPassword($hashedPassworn);
        $user->setUsername($data['username']);
        $userRepository->save($user);
        return $this->json([
            'message' => 'Usuário criado com sucesso!'
        ]);
    }
}
