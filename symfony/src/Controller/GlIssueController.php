<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlTimeNote;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/issue', name: 'issue-', defaults: ['_format' => 'json'])]
class GlIssueController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $issues = $this->filtrateAndPaginate($request, GlIssue::class);

            if ($issues['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($issues['items'], Response::HTTP_OK, ['X-Total-Items' => $issues['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }

    }

    #[Route(
        path: '/{id}/time-note',
        name: 'time-note-list',
        defaults: [
            '_api_resource_class' => GlIssue::class,
        ],
        methods: ['GET'],
    )]
    public function getProjectIssues(GlIssue $issue, Request $request): JsonResponse
    {
        $where = [
            [
                GetEntities::PARAM_RELATION => GlTimeNote::class,
                GetEntities::PARAM_VALUE => $issue->getGlId(),
                GetEntities::PARAM_JOIN => 'join',
                GetEntities::PARAM_FIELD => 'glIssueId'
            ],
        ];

        try {
            $result = $this->filtrateAndPaginate($request, GlTimeNote::class, $where);

            if ($result['count'] === 0) {
                return $this->json([], 204);
            }

            return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }
}
