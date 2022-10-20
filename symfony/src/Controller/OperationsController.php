<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Repository\Main\AppUserRepository;
use App\Service\GitlabService;
use App\Service\UtilService;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/operations/', name: 'user-', defaults: ['_format' => 'json'])]
class OperationsController extends AbstractTimeTrackerController
{
    protected AppUserRepository $repository;

    public function __construct(GetEntities $getEntitiesService, UtilService $utilService, AppUserRepository $repository)
    {
        parent::__construct($getEntitiesService, $utilService);
        $this->repository = $repository;
    }

    #[Route(
        path: 'issue/{id}/time-note',
        name: 'issue-time-note',
        defaults: [
            '_api_resource_class' => GlIssue::class,
        ],
        methods: ['POST']
    )]
    public function postTimeNote(GlIssue $issue, Request $request, GitlabService $service)
    {
        try {

            var_dump($request->getContent());die;

            $appUser = $this->repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $data = $service->postTimeNote($issue, $appUser);
            return $this->json($data, Response::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(
        path: 'issue/{issueId}/time-note/{id}',
        name: 'issue-time-note',
        defaults: [
            'issueId' => GlIssue::class,
            'id' => GlProject::class,
        ],
        methods: ['POST']
    )]
    public function putTimeNote(GlIssue $issue, Request $request, GitlabService $service)
    {
        try {
            $appUser = $this->repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $data = $service->postTimeNote($issue, $appUser);
            return $this->json($data, Response::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
    }
}
