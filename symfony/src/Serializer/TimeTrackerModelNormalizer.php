<?php

namespace App\Serializer;

use App\Model\TimeTrackerModelInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TimeTrackerModelNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $reflectionClass = new \ReflectionClass($type);
        $result = $reflectionClass->newInstance();

        $methods = $reflectionClass->getMethods();

        foreach ($data as $key => $value) {
            $parts = explode('_', $key);
            for ($i = 0; $i < sizeof($parts); $i++) {
                $parts[$i] = ucfirst($parts[$i]);
            }
            $property = lcfirst(implode('', $parts));
            $method = 'set'. ucfirst($property) ;

            if (array_filter($methods, fn(\ReflectionMethod $r) => $r->getName() === $method)) {
                $propertyType = $reflectionClass->getProperty($property)->getType()->getName();
                if ($propertyType === \DateTimeInterface::class) {
                    $value = new \DateTime($value);
                }

                $refMethod = $reflectionClass->getMethod($method);
                $refMethod->invoke($result, $value);
            }
        }

        return $result;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        $class = new \ReflectionClass($type);

        if (!$class->implementsInterface(TimeTrackerModelInterface::class)) {
            return false;
        }
        return true;
    }
}
