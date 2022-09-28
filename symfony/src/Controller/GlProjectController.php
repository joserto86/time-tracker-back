<?php

namespace App\Controller;

use App\Entity\GlIssue;
use App\Entity\GlProject;
use App\Entity\GlTimeNote;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/project', name: 'project-', defaults: ['_format' => 'json'])]
class GlProjectController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $projects = $this->filtrateAndPaginate($request, GlProject::class);

        if ($projects['count'] === 0) {
            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        return $this->json($projects['items'], Response::HTTP_OK, ['X-Total-Items' => $projects['count']]);
    }

    #[Route(
        path: '/{id}/issue',
        name: 'issue-list',
        defaults: [
            '_api_resource_class' => GlProject::class,
            '_api_operation_name' => '_api_/project/{id}/issue-list',
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

        if ($result['count'] === 0) {
            return $this->json([], 204);
        }

        return $this->json(array_reverse($result['items']), 200, ['X-Total-Items' => $result['count']]);
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

        $result = $this->filtrateAndPaginate($request, GlTimeNote::class, $where);

        if ($result['count'] === 0) {
            return $this->json([], 204);
        }

        return $this->json(array_reverse($result['items']), 200, ['X-Total-Items' => $result['count']]);
    }
}
