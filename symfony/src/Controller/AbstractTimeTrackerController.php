<?php

namespace App\Controller;

use App\Service\UtilService;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractTimeTrackerController extends AbstractController
{
    protected GetEntities $getEntitiesService;

    protected UtilService $utilService;

    public function __construct(
        GetEntities $getEntitiesService,
        UtilService $utilService,
    ) {
        $this->getEntitiesService = $getEntitiesService;
        $this->utilService = $utilService;
    }

    protected function filtrateAndPaginate(Request $request, string $entityName, array $where = []): array
    {
        try {
            $page = intval($request->get('page', 1));
            $limit = (int)$request->get('limit', -1);

            $where = array_merge($where, $this->getEntitiesService->parseWhere($request->get('where', '{}')));
            $order = $this->getEntitiesService->prepareOrder($request->get('order', $this->utilService->getDefaultFieldOrderName($entityName)));
            $count = $this->getEntitiesService->count($entityName, $where, false);

            if($count === 0){
                return ['items' => [], 'count' => $count];
            }

            $items = $this->getEntitiesService->fetch($entityName, $where, $order, $limit, $page, false);

            return ['items' => $items, 'count' => $count];
        } catch (\Exception $e) {
            throw new \LogicException("request.params.incorrect", Response::HTTP_BAD_REQUEST);
        }
    }
}
