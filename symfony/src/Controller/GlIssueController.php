<?php

namespace App\Controller;

use App\Entity\GlIssue;
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
        $users = $this->filtrateAndPaginate($request, GlIssue::class);
        return $this->json($users['items'], Response::HTTP_OK, ['X-Total-Items' => $users['count']]);
    }
}
