<?php

namespace App\Controller;

use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractTimeTrackerController extends AbstractController
{
    protected GetEntities $getEntitiesService;

    public function __construct(
        GetEntities $getEntitiesService
    ) {
        $this->getEntitiesService = $getEntitiesService;
    }

    protected function filtrateAndPaginate(Request $request, string $entityName, array $where = []): array
    {
        $page = intval($request->get('page', 1));
        $limit = (int)$request->get('limit', -1);

        $where = array_merge($where, $this->getEntitiesService->parseWhere($request->get('where', '{}')));
        $order = $this->getEntitiesService->prepareOrder($request->get('order'));
        $count = $this->getEntitiesService->count($entityName, $where, false);

        if($count === 0){
            return ['items' => [], 'count' => $count];
        }

        $items = $this->getEntitiesService->fetch($entityName, $where, $order, $limit, $page, false);

        return ['items' => $items, 'count' => $count];
    }
}
