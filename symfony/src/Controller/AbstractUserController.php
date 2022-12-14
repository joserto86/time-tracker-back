<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Entity\Glquery\User;
use App\Entity\Glquery\ViewGlTimeNote;
use App\Repository\Glquery\GlProjectRepository;
use App\Repository\Glquery\UserRepository;
use App\Service\UtilService;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractUserController extends AbstractTimeTrackerController
{
    protected UserRepository $userRepository;

    public function __construct(GetEntities $getEntitiesService, UtilService $utilService, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($getEntitiesService, $utilService);
    }

    protected function getGlUsers() :array
    {
        return $this->userRepository->findBy(['ldapUser' => $this->getUser()->getUserIdentifier()]);
    }

    protected function getGlUserByInstance(string $instance): ?User
    {
        return $this->userRepository->findOneBy([
            'username' => $this->getUser()->getUserIdentifier(),
            'instance' => $instance
        ]);
    }

    protected function getProjectsByUser(array $users, Request $request, GlProjectRepository $repository): JsonResponse
    {
        try {
            $result = $repository->getProjectsByUser($request, $users);

            if ($result['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    protected function getIssuesByUserAndProject(User $user, GlProject $project, Request $request): JsonResponse
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

    protected function getTimeNotesByUserAndProject(User $user, GlProject $project, Request $request): JsonResponse
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

    protected function getTimeNotesByUser(array $users, Request $request): JsonResponse
    {
        $where = [];

        /** @var User $user */
        foreach ($users as $user) {
            $where[] = [
                GetEntities::PARAM_VALUE => $user->getUsername(),
                GetEntities::PARAM_FIELD => 'author',
            ];
            $where[] = [
                GetEntities::PARAM_VALUE => $user->getInstance(),
                GetEntities::PARAM_FIELD => 'glInstance'
            ];
        }

        try {
            $issues = $this->filtrateAndPaginate($request, ViewGlTimeNote::class, $where);

            if ($issues['count'] === 0) {
                return $this->json([], Response::HTTP_OK);
            }

            return $this->json($issues['items'], Response::HTTP_OK, ['X-Total-Items' => $issues['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    protected function getIssuesByUser(array $users, Request $request): JsonResponse
    {
        $where = [];

        /** @var User $user */
        foreach ($users as $user) {
            $where[] = [
                GetEntities::PARAM_VALUE => $user->getUsername(),
                GetEntities::PARAM_FIELD => 'assignee',
            ];
            $where[] = [
                GetEntities::PARAM_VALUE => $user->getInstance(),
                GetEntities::PARAM_FIELD => 'glInstance'
            ];
        }

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

    protected function getTimeNotesByUserAndIssue(User $user, GlIssue $issue, Request $request): JsonResponse
    {
        $where = [
            [
                GetEntities::PARAM_VALUE => $user->getUsername(),
                GetEntities::PARAM_FIELD => 'author',
            ], [
                GetEntities::PARAM_VALUE => $user->getInstance(),
                GetEntities::PARAM_FIELD => 'glInstance'
            ], [
                GetEntities::PARAM_VALUE => $issue->getGlId(),
                GetEntities::PARAM_FIELD => 'glIssueId'
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
