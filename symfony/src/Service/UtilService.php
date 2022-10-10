<?php

namespace App\Service;

use Irontec\SymfonyTools\GetEntities\GetEntities;
use ReflectionException;

class UtilService
{
    protected GetEntities $getEntities;

    public function __construct(GetEntities $getEntities)
    {
        $this->getEntities = $getEntities;
    }


    /**
     * @throws ReflectionException
     */
    public function getDefaultFieldOrderName(string $entityName): string
    {
        $reflector = new \ReflectionClass($entityName);
        $attributes = $reflector->getProperties();
        $first = $attributes[0];
        return  sprintf('[{"field":"%s","order":"ASC"}]', $first->getName());
    }
}
