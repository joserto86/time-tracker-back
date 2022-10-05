<?php

namespace App\Controller;

use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use App\Repository\Main\AppUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/instance', name: 'instances-')]
class InstanceController extends AbstractController
{
    protected GetEntities $getEntitiesService;

    public function __construct(
        GetEntities $getEntitiesService
    ) {
        $this->getEntitiesService = $getEntitiesService;
    }

    #[Route(name: 'list', methods: ['GET'])]
    public function index(Request $request)
    {
        $page = intval($request->get('page', 1));
        $limit = (int)$request->get('limit', -1);

        $where = $this->getEntitiesService->parseWhere($request->get('where', '{}'));
        $order = $this->getEntitiesService->prepareOrder($request->get('order'));
        $count = $this->getEntitiesService->count(Instance::class, $where, false);

        if($count === 0){
            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        $items = $this->getEntitiesService->fetch(Instance::class, $where, $order, $limit, $page, false);

        return $this->json($items, Response::HTTP_OK, ['X-Total-Items' => $count]);
    }

    #[Route(path: '/{id}', name: 'post-token', methods: ['POST'], defaults: ['_api_resource_class' => Instance::class])]
    public function postToken(Instance $instance, Request $request, EntityManagerInterface $em)
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
