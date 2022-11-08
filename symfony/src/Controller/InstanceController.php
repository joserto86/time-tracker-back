<?php

namespace App\Controller;

use App\Entity\Main\AppUser;
use App\Entity\Main\Instance;
use App\Repository\Main\AppUserRepository;
use App\Service\GitlabService;
use App\Service\InstanceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/instance', name: 'instance-')]
class InstanceController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request,  AppUserRepository $repository) :JsonResponse
    {
        try {
            $data = $this->filtrateAndPaginate($request, Instance::class);

            return $this->json($data['items'], Response::HTTP_OK, ['X-Total-Items' => $data['count']]);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    #[Route(path: '/{id}', name: 'item', defaults: ['_api_resource_class' => Instance::class], methods: ['GET'])]
    public function show(Instance $instance, AppUserRepository $repository): JsonResponse
    {
        try {
           return $this->json($instance, Response::HTTP_OK);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }



    #[Route(path: '/{id}', name: 'update', defaults: ['_api_resource_class' => Instance::class], methods: ['PUT', 'PATCH'])]
    public function postToken(Instance $instance, Request $request, EntityManagerInterface $em, InstanceService $service): JsonResponse
    {
        try {
            $user = $em->getRepository(AppUser::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $service->update($user, $instance, new ParameterBag($request->request->all()));
            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }

    }

    #[Route(
        path: '/{id}/status',
        name: 'status',
        defaults: [
            '_api_resource_class' => Instance::class,
        ],
        methods: ['GET'])]
    public function getInstanceStatus(Instance $instance, GitlabService $service, AppUserRepository $repository) :JsonResponse
    {
        try {
            $user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $status = $service->status($instance, $user);

            return $this->json($status, Response::HTTP_OK);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }

    }

    #[Route(
        path: '/{id}/user-data',
        name: 'user-data',
        defaults: [
            '_api_resource_class' => Instance::class,
        ],
        methods: ['GET'])]
    public function getInstanceUserData(Instance $instance, GitlabService $service, AppUserRepository $repository): JsonResponse
    {
        try {
            $user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
            $data = $service->getUserData($instance, $user);

            return $this->json($data, Response::HTTP_OK);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }
}
