<?php

namespace App\Controller;

use App\Model\Filter;
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
class FiltersController extends AbstractController
{
    #[Route(
        path: '/filters',
        name: 'filters-get',
        methods: ['GET'],
    )]
    public function getUserFilters(AppUserRepository $repository): JsonResponse
    {
        if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {
            return $this->json($user->getFilters(),  Response::HTTP_OK);
        }

        return $this->json(null, Response::HTTP_NOT_FOUND);
    }

    #[Route(
        path: '/filters',
        name: 'filters-post',
        methods: ['POST'],
    )]
    public function postUserFilters(
        Request $request,
        AppUserRepository $repository,
        SerializerInterface $serializer,
        EntityManagerInterface $em
    ): JsonResponse
    {
        try {
            if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {
                $filtersRequest = json_decode($request->getContent());
                foreach ($filtersRequest as $item) {
                    /** @var Filter $filter */
                    $filter = $serializer->deserialize(json_encode($item), Filter::class, JsonEncoder::FORMAT);
                    if (!$filter->isValid()) {
                        throw new LogicException('Invalid filters data', Response::HTTP_BAD_REQUEST);
                    }
                }

                $user->setFilters($filtersRequest);
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
        path: '/filters',
        name: 'filters-delete',
        methods: ['DELETE'],
    )]
    public function deleteUserFilters(AppUserRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        if ($user = $repository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])) {
            $user->setFilters(null);
            $em->persist($user);
            $em->flush();

            return $this->json([],  Response::HTTP_OK);
        }

        return $this->json([], Response::HTTP_NOT_FOUND);
    }
}
