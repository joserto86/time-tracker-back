<?php

namespace App\Normalizer;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractNormalizer
{
    protected const DEFAULT_FORMAT_DATE = 'Y-m-d H:i:s';

    protected EntityManagerInterface $em;

    public function __construct (EntityManagerInterface $em)
    {
        $this->em = $em;
    }

//    /**
//     * @throws \ReflectionException
//     */
//    protected function basicNormalize(mixed $object, string $type): mixed
//    {
//        $refObject = new \ReflectionObject($object);
//        $srcGetMethods = array_filter($refObject->getMethods(), fn(\ReflectionMethod $m) => str_contains( $m->getName(), 'get'));
//
//        $reflectionClass = new \ReflectionClass($type);
//        $result = $reflectionClass->newInstance();
//
//        /** @var \ReflectionMethod $method */
//        foreach ($srcGetMethods as $method) {
//            $setMethod = str_replace('get', 'set', $method->getName());
//
//            if ($refMethod = $reflectionClass->getMethod($setMethod)) {
//                $value = $method->invoke($object);
//                $refMethod->invoke($result, $value);
//            }
//        }
//
//        return $result;
//    }
//
//    protected function dismount(mixed $object)
//    {
//        $reflectionClass = new \ReflectionClass(get_class($object));
//        $array = array();
//        foreach ($reflectionClass->getProperties() as $property) {
//            $propertyType = $property->getType()->getName();
//            if ($propertyType === \DateTimeInterface::class) {
//                $value = new \DateTime($value);
//
//                $array[$property->getName()] = $property->getValue($object);
//            } else {
//
//                $array[$property->getName()] = $property->getValue($object);
//            }
//
//        }
//        return $array;
//    }
}
