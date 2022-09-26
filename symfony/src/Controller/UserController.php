<?php

namespace App\Controller;

use App\Entity\User;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'user-', defaults: ['_format' => 'json'])]
class UserController extends AbstractTimeTrackerController
{
//    #[Route(name: 'list', methods: ['GET'], defaults: ['page' => 1, 'limit' => '10'])]
    #[Route(name: 'list', methods: ['GET'])]
    public function list(
        Request     $request,
    ): JsonResponse
    {
        $users = $this->filtrateAndPaginate($request, User::class);
        return $this->json($users['items'], Response::HTTP_OK, ['X-Total-Items' => $users['count']]);
    }
}
