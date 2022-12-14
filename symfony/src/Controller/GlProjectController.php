<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Model\GlMilestone;
use App\Repository\Glquery\GlIssueRepository;
use App\Repository\Glquery\GlProjectRepository;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api/project', name: 'project-', defaults: ['_format' => 'json'])]
class GlProjectController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $projects = $this->filtrateAndPaginate($request, GlProject::class);

            if ($projects['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($projects['items'], Response::HTTP_OK, ['X-Total-Items' => $projects['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    #[Route(
        path: '/{id}/issue',
        name: 'issue-list',
        defaults: [
            '_api_resource_class' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getProjectIssues(GlProject $project, Request $request): JsonResponse
    {
        $where = [
            [
                GetEntities::PARAM_RELATION => GlIssue::class,
                GetEntities::PARAM_VALUE => $project->getGlId(),
                GetEntities::PARAM_JOIN => 'join',
                GetEntities::PARAM_FIELD => 'glProjectId'
            ],
        ];

        $result = $this->filtrateAndPaginate($request, GlIssue::class, $where);

        try {
            if ($result['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json(array_reverse($result['items']), 200, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    #[Route(
        path: '/{id}/time-note',
        name: 'time-note-list',
        defaults: [
            '_api_resource_class' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getProjectTimeNotes(GlProject $project, Request $request): JsonResponse
    {
        $where = [
            [
                GetEntities::PARAM_RELATION => GlTimeNote::class,
                GetEntities::PARAM_VALUE => $project->getGlId(),
                GetEntities::PARAM_JOIN => 'join',
                GetEntities::PARAM_FIELD => 'glProjectId'
            ],
        ];

        try {
            $result = $this->filtrateAndPaginate($request, GlTimeNote::class, $where);

            if ($result['count'] === 0) {
                return $this->json([], 204);
            }

            return $this->json(array_reverse($result['items']), 200, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    #[Route(
        path: '/{id}/milestone',
        name: 'milestone-list',
        defaults: [
            '_api_resource_class' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getProjectMilestones(GlProject $project, Request $request, GlIssueRepository $repository)
    {
        try{
            $result = $repository->getMilestonesByProject($request, $project);

            if ($result['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']]);

        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }
}
