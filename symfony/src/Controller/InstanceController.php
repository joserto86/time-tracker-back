<?php

namespace App\Controller;

use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use App\Repository\Main\AppUserRepository;
use App\Service\GitlabService;
use App\Service\InstanceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route(path: '/{id}', name: 'post-token', defaults: ['_api_resource_class' => Instance::class], methods: ['POST'])]
    public function postToken(Instance $instance, Request $request, EntityManagerInterface $em, InstanceService $service): JsonResponse
    {
        $user = $em->getRepository(AppUser::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
        $token = $request->request->get('token');

        $appUserInstance = $service->getAppUserInstance($instance, $user);

        if ($appUserInstance) {
            $appUserInstance->setToken($token);
        } else {
            $appUserInstance = new AppUserInstance();
            $appUserInstance->setToken($token)->setInstance($instance);
            $user->addAppUserInstance($appUserInstance);
            $em->persist($user);
        }

        $em->persist($appUserInstance);
        $em->flush();

        return $this->json(null, Response::HTTP_CREATED);
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
