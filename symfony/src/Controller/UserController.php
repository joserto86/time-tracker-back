<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\GlProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'user-', defaults: ['_format' => 'json'])]
class UserController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $users = $this->filtrateAndPaginate($request, User::class);

        if ($users['count'] === 0) {
            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        return $this->json($users['items'], Response::HTTP_OK, ['X-Total-Items' => $users['count']]);
    }

    #[Route(
        path: '/{id}/project',
        name: 'project-list',
        defaults: [
            '_api_resource_class' => User::class,
        ],
        methods: ['GET'],
    )]
    public function getUserProjects(User $user, Request $request, GlProjectRepository $repository): JsonResponse
    {
        $result = $repository->getProjectsByUser($request, $user);

        if ($result['count'] === 0) {
            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        return $this->json(array_reverse($result['items']), Response::HTTP_OK, ['X-Total-Items' => $result['count']]);
    }
}
