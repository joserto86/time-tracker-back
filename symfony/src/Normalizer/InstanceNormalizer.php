<?php

namespace App\Normalizer;

use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InstanceNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        parent::__construct($em);
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /** @var $object Instance */

        /** @var AppUser $user */
        $user = $this->em->getRepository(AppUser::class)
            ->findOneBy(['username' => $this->tokenStorage->getToken()->getUserIdentifier()]);

        $result = [
            'id'    => $object->getId(),
            'url'   => $object->getUrl(),
        ];

        if (sizeof($user->getAppUserInstances()) === 0) {
           return $result;
        }

        $appUserInstance = array_values(array_filter(
            $user->getAppUserInstances()->toArray(), fn(AppUserInstance $i) => $i->getInstance() === $object
        ))[0];

        $result['username'] = $appUserInstance->getUsername();
        $result['added'] = !empty($appUserInstance->getToken());
        return $result;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Instance;
    }
}
