<?php

namespace App\Controller;

use App\Entity\GlProject;
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
        $users = $this->filtrateAndPaginate($request, GlProject::class);
        return $this->json($users['items'], Response::HTTP_OK, ['X-Total-Items' => $users['count']]);
    }
}
