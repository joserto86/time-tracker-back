<?php

namespace App\Controller;

use App\Model\Profile;
use App\Repository\Main\AppUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'user-', defaults: ['_format' => 'json'])]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile-get', methods: ['GET'])]
    public function index(AppUserRepository $repository): JsonResponse
    {
        if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {
            if ($result = $user->getProfile()) {
                return $this->json(json_decode($user->getProfile()),  Response::HTTP_OK);
            }

            return $this->json(null,  Response::HTTP_OK);
        }

        return $this->json([], Response::HTTP_NOT_FOUND);
    }

    #[Route(
        path: '/profile',
        name: 'profile-post',
        methods: ['POST'],
    )]
    public function post(
        Request $request,
        AppUserRepository $repository,
        SerializerInterface $serializer,
        EntityManagerInterface $em
    ): JsonResponse
    {
        try {
            if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {

                /** @var Profile $profile */
                $profile = $serializer->deserialize($request->getContent(), Profile::class, JsonEncoder::FORMAT);
                if (!$profile->isValid()) {
                    throw new LogicException('Invalid profile data', Response::HTTP_BAD_REQUEST);
                }

                $user->setProfile(json_encode(json_decode($request->getContent())));
                $em->persist($user);
                $em->flush();

                return $this->json([], Response::HTTP_CREATED);
            }

            return $this->json([], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(
        path: '/profile',
        name: 'profile-delete',
        methods: ['DELETE'],
    )]
    public function delete(AppUserRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {
            $user->setProfile(null);
            $em->persist($user);
            $em->flush();

            return $this->json([],  Response::HTTP_OK);
        }

        return $this->json([], Response::HTTP_NOT_FOUND);
    }
}
