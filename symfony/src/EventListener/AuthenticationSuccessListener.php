<?php

namespace App\EventListener;

use App\Entity\Main\AppUser;
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

        /** @var AppUser $userLocal */
        if (!$userLocal = $this->em->getRepository(AppUser::class)->findOneBy(['username' => $user->getUsername()])) {
            $userLocal = new AppUser();
            $userLocal->setUsername($user->getUsername());
            $userLocal->setRoles($user->getRoles());
            $this->em->persist($userLocal);
            $this->em->flush();
        }
    }
}
