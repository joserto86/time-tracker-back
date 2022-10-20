<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Model\TimeNote;
use App\Repository\Main\AppUserRepository;
use App\Service\GitlabService;
use App\Service\UtilService;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function postTimeNote(GlIssue $issue, Request $request, GitlabService $service, SerializerInterface $serializer)
    {
        try {
            $appUser = $this->repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $timeNote = $serializer->deserialize($request->getContent(), TimeNote::class, JsonEncoder::FORMAT);
            $data = $service->postTimeNote($issue, $appUser, $timeNote);
            return $this->json($data, Response::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
    }

//    #[Route(
//        path: 'issue/{issueId}/time-note/{id}',
//        name: 'issue-time-note',
//        defaults: [
//            'issueId' => GlIssue::class,
//            'id' => GlProject::class,
//        ],
//        methods: ['PUT']
//    )]
//    public function putTimeNote(GlIssue $issue, Request $request, GitlabService $service)
//    {
//        try {
//            $appUser = $this->repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
//            $data = $service->postTimeNote($issue, $appUser);
//            return $this->json($data, Response::HTTP_OK);
//
//        } catch (\Exception $e) {
//            return $this->json([], Response::HTTP_BAD_REQUEST);
//        }
//    }
}
