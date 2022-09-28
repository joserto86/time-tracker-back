<?php

namespace App\Controller;

use App\Entity\GlTimeNote;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/time-note', name: 'time-note-', defaults: ['_format' => 'json'])]
class GlTimeNoteController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $result = $this->filtrateAndPaginate($request, GlTimeNote::class);

        if ($result['count'] === 0) {
            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']]);
    }
}
