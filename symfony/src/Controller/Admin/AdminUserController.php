<?php

namespace App\Controller\Admin;

use App\Controller\AbstractUserController;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\User;
use App\Repository\Glquery\GlProjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin/user', name: 'admin-user', defaults: ['_format' => 'json'])]
class AdminUserController extends AbstractUserController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        try {
            $users = $this->filtrateAndPaginate($request, User::class);

            if ($users['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($users['items'], Response::HTTP_OK, ['X-Total-Items' => $users['count']]);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
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
        return $this->getProjectsByUser([$user], $request, $repository);
    }

    #[Route(
        path: '/{id}/project/{project}/issue',
        name: 'project-issue-list',
        defaults: [
            'id' => User::class,
            'project' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getUserProjectIssues(User $user, GlProject $project, Request $request): JsonResponse
    {
        return $this->getIssuesByUserAndProject($user, $project, $request);
    }

    #[Route(
        path: '/{id}/project/{project}/time-note',
        name: 'project-time-note-list',
        defaults: [
            'id' => User::class,
            'project' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getUserProjectTimeNotes(User $user, GlProject $project, Request $request): JsonResponse
    {
        return $this->getTimeNotesByUserAndProject($user, $project, $request);
    }

    #[Route(
        path: '/{id}/issue',
        name: 'time-note-list',
        defaults: [
            '_api_resource_class' => User::class,
        ],
        methods: ['GET'],
    )]
    public function getUserTimeNotes(User $user, Request $request): JsonResponse
    {
        return $this->getTimeNotesByUser([$user], $request);
    }

    #[Route(
        path: '/{id}/time-note',
        name: 'issue-list',
        defaults: [
            '_api_resource_class' => User::class,
        ],
        methods: ['GET'],
    )]
    public function getUserIssues(User $user, Request $request): JsonResponse
    {
        return $this->getIssuesByUser([$user], $request);
    }
}
