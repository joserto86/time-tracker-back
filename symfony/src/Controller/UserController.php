<?php

namespace App\Controller;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Model\TimeNote;
use App\Repository\Glquery\GlIssueRepository;
use App\Repository\Glquery\GlProjectRepository;
use App\Repository\Glquery\GlTimeNoteRepository;
use App\Repository\Main\AppUserRepository;
use App\Service\GitlabService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/user', name: 'user-', defaults: ['_format' => 'json'])]
class UserController extends AbstractUserController
{
    #[Route(
        path: '/project',
        name: 'project-list',
        methods: ['GET'],
    )]
    public function getUserProjects(Request $request, GlProjectRepository $repository): JsonResponse
    {
        $users = $this->getGlUsers();
        if (empty($users)) {
            return $this->json([], Response::HTTP_OK, ['X-Total-Items' => 0], ['groups' => 'list']);
        }
        return $this->getProjectsByUser($users, $request, $repository);
    }

    #[Route(
        path: '/project/{project}/issue',
        name: 'project-issue-list',
        defaults: [
            'project' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getUserProjectIssues(GlProject $project, Request $request): JsonResponse
    {
        $user = $this->getGlUserByInstance($project->getGlInstance());
        return $this->getIssuesByUserAndProject($user, $project, $request);

    }

    #[Route(
        path: '/project/{project}/time-note',
        name: 'project-time-note-list',
        defaults: [
            'project' => GlProject::class,
        ],
        methods: ['GET'],
    )]
    public function getUserProjectTimeNotes(GlProject $project, Request $request): JsonResponse
    {
        $user = $this->getGlUserByInstance($project->getGlInstance());
        return $this->getTimeNotesByUserAndProject($user, $project, $request);
    }

    #[Route(
        path: '/time-note',
        name: 'time-note-list',
        methods: ['GET'],
    )]
    public function getUserTimeNotes(Request $request): JsonResponse
    {
        $users = $this->getGlUsers();
        if (empty($users)) {
            return $this->json([], Response::HTTP_OK, ['X-Total-Items' => 0], ['groups' => 'list']);
        }

        return $this->getTimeNotesByUser($users, $request);
    }

    #[Route(
        path: '/issue',
        name: 'issue-list',
        methods: ['GET'],
    )]
    public function getUserIssues(Request $request): JsonResponse
    {
        $users = $this->getGlUsers();
        if (empty($users)) {
            return $this->json([], Response::HTTP_OK, ['X-Total-Items' => 0], ['groups' => 'list']);
        }

        return $this->getIssuesByUser($users, $request);
    }

    #[Route(
        path: '/issue/{id}/time-note',
        name: 'issue-time-note-list',
        defaults: [
            '_api_resource_class' => GlIssue::class,
        ],
        methods: ['GET'],
    )]
    public function getUserTimeNotesByIssue(GlIssue $issue, Request $request): JsonResponse
    {
        $user = $this->getGlUserByInstance($issue->getGlInstance());
        return $this->getTimeNotesByUserAndIssue($user, $issue, $request);
    }

    #[Route(
        path: '/issue/{id}/time-note',
        name: 'issue-time-note-post',
        defaults: [
            '_api_resource_class' => GlIssue::class,
        ],
        methods: ['POST']
    )]
    public function postTimeNote(
        GlIssue $issue,
        Request $request,
        GitlabService $service,
        SerializerInterface $serializer,
        AppUserRepository $repository
    ): JsonResponse
    {
        try {
            $appUser = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $timeNote = $serializer->deserialize($request->getContent(), TimeNote::class, JsonEncoder::FORMAT);
            $data = $service->postTimeNote($issue, $appUser, $timeNote);
            return $this->json($data, Response::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(
        path: '/issue/{issueId}/time-note/{id}',
        name: 'issue-time-note-get',
        defaults: [
            'id' => GlTimeNote::class
        ],
        methods: ['GET'],
    )]
    public function getUserTimeNoteByIssueAndTimeNoteId(
        int $issueId,
        GlTimeNote $timeNote,
        GlTimeNoteRepository $repository,
        GlIssueRepository $glIssueRepository
    ): JsonResponse
    {
        $issue = $glIssueRepository->find($issueId);

        if ($issue) {
            $user = $this->getGlUserByInstance($issue->getGlInstance());
            $result = $repository->findOneBy([
                'id' => $timeNote->getId(),
                'glIssueId' => $issue->getGlId(),
                'author' => $user->getUsername(),
                'glInstance' => $user->getInstance()
            ]);

            if ($result) {
                return $this->json($result, Response::HTTP_OK);
            }
        }

        return  $this->json([], Response::HTTP_NOT_FOUND);
    }

    #[Route(
        path: '/issue/{issueId}/time-note/{id}',
        name: 'issue-time-note-put',
        defaults: [
            'id' => GlTimeNote::class,
        ],
        methods: ['PUT']
    )]
    public function putTimeNote(
        int $issueId,
        GlTimeNote $timeNote,
        Request $request,
        GitlabService $service,
        SerializerInterface $serializer,
        AppUserRepository $repository,
        GlIssueRepository $glIssueRepository,
    ) :JsonResponse
    {
        try {
            $user = $this->getGlUserByInstance($timeNote->getGlInstance());
            $appUser = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);

            if ($user->getUsername() === $timeNote->getAuthor()) {
                $issue = $glIssueRepository->find($issueId);
                $body = $serializer->deserialize($request->getContent(), TimeNote::class, JsonEncoder::FORMAT);
                $data = $service->putTimeNote($issue, $appUser, $body, $timeNote);
                return $this->json($data, Response::HTTP_OK);
            }

            return $this->json('Can\'t update TimeNote of another person', Response::HTTP_UNAUTHORIZED);

        } catch (\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(
        path: '/issue/{issueId}/time-note/{id}',
        name: 'issue-time-note-delete',
        defaults: [
            'id' => GlTimeNote::class,
        ],
        methods: ['DELETE']
    )]
    public function deleteTimeNote(
        int $issueId,
        GlTimeNote $timeNote,
        GitlabService $service,
        AppUserRepository $repository,
        GlIssueRepository $glIssueRepository,
    ) :JsonResponse
    {
        try {
            $user = $this->getGlUserByInstance($timeNote->getGlInstance());
            $appUser = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);

            if ($user->getUsername() === $timeNote->getAuthor()) {
                $issue = $glIssueRepository->find($issueId);
                $data = $service->deleteTimeNote($issue, $appUser, $timeNote);
                return $this->json($data, Response::HTTP_OK);
            }

            return $this->json('Can\'t delete TimeNote of another person', Response::HTTP_UNAUTHORIZED);

        } catch (\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
