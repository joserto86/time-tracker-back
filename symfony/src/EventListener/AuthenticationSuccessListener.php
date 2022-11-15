<?php

namespace App\EventListener;

use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Ldap\Security\LdapUser;

class AuthenticationSuccessListener
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof LdapUser) {
            return;
        }

        $flush = false;

        /** @var AppUser $userLocal */
        $userLocal = $this->em->getRepository(AppUser::class)->findOneBy(['username' => $user->getUsername()]);
        if (!$userLocal) {
            $userLocal = new AppUser();
            $userLocal->setUsername($user->getUsername());
            $userLocal->setRoles($user->getRoles());

            $this->em->persist($userLocal);
            $flush = true;
        }

        $instances = $this->em->getRepository(Instance::class)->findAll();
        foreach ($instances as $instance) {
            $appUserInstance = $this->getUserAppInstance($userLocal, $instance);
            if (!$appUserInstance) {
                $appUserInstance = new AppUserInstance();
                $appUserInstance->setInstance($instance);
                $this->em->persist($appUserInstance);
                $userLocal->addAppUserInstance($appUserInstance);

                $flush = true;
            }
        }

        if ($flush) {
            $this->em->flush();
        }
    }

    private function getUserAppInstance(AppUser $userLocal, Instance $instance): ?AppUserInstance
    {
        foreach ($userLocal->getAppUserInstances() as $userInstance) {
            if ($userInstance->getInstance()->getId() === $instance->getId()) {
                return $userInstance;
            }
        }
        return null;
    }
}
