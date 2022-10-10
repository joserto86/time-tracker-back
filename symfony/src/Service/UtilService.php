<?php

namespace App\Service;

use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilService
{
    protected GetEntities $getEntities;

    public function __construct(GetEntities $getEntities)
    {
        $this->getEntities = $getEntities;
    }


    public function getDefaultFieldOrderName(string $entityName): string
    {
        $reflector = new \ReflectionClass($entityName);
        $attributes = $reflector->getProperties();
        /** @var \ReflectionProperty $first */
        $first = $attributes[0];
        return  sprintf('[{"field":"%s","order":"ASC"}]', $first->getName());
    }
}
