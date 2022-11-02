<?php

namespace App\Normalizer;

use App\Entity\Main\Instance;
use App\Model\Instance as InstanceModel;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InstanceNormalizer extends AbstractNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $result = $this->basicNormalize($object, InstanceModel::class);
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Instance;
    }
}
