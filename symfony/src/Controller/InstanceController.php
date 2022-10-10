<?php

namespace App\Controller;

use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/instance', name: 'instance-')]
class InstanceController extends AbstractTimeTrackerController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request) :JsonResponse
    {
        try {
            $result = $this->filtrateAndPaginate($request, Instance::class);

            if ($result['count'] === 0) {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }

            return $this->json($result['items'], Response::HTTP_OK, ['X-Total-Items' => $result['count']], ['groups' => 'list']);
        } catch (\LogicException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }

    #[Route(path: '/{id}', name: 'post-token', defaults: ['_api_resource_class' => Instance::class], methods: ['POST'])]
    public function postToken(Instance $instance, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(AppUser::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
        $token = $request->request->get('token');

        $appUserInstance = $em->getRepository(AppUserInstance::class)->findOneBy([
            'instance' => $instance,
            'appUser' => $user
        ]);

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

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
