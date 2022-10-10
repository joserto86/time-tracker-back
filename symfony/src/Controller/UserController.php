<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Entity\Glquery\User;
use App\Repository\Glquery\GlIssueRepository;
use App\Repository\Glquery\GlProjectRepository;
use Irontec\SymfonyTools\GetEntities\GetEntities;
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
        try {
            $result = $repository->getProjectsByUser($request, $user);

            if ($result['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
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
        $where = [
            [
                GetEntities::PARAM_VALUE => $user->getUsername(),
                GetEntities::PARAM_FIELD => 'assignee',
            ], [
                GetEntities::PARAM_VALUE => $user->getInstance(),
                GetEntities::PARAM_FIELD => 'glInstance'
            ], [
                GetEntities::PARAM_VALUE => $project->getGlId(),
                GetEntities::PARAM_FIELD => 'glProjectId'
            ]
        ];

        try {
            $issues = $this->filtrateAndPaginate($request, GlIssue::class, $where);

            if ($issues['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($issues['items'], Response::HTTP_OK, ['X-Total-Items' => $issues['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
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
        $where = [
            [
                GetEntities::PARAM_VALUE => $user->getUsername(),
                GetEntities::PARAM_FIELD => 'author',
            ], [
                GetEntities::PARAM_VALUE => $user->getInstance(),
                GetEntities::PARAM_FIELD => 'glInstance'
            ], [
                GetEntities::PARAM_VALUE => $project->getGlId(),
                GetEntities::PARAM_FIELD => 'glProjectId'
            ]
        ];

        try {
            $issues = $this->filtrateAndPaginate($request, GlTimeNote::class, $where);

            if ($issues['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($issues['items'], Response::HTTP_OK, ['X-Total-Items' => $issues['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }
}
