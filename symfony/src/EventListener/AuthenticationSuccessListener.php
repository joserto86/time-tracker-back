<?php

namespace App\EventListener;

use App\Entity\Main\Admin;
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

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof LdapUser) {
            return;
        }

        /** @var Admin $userLocal */
        if (!$userLocal = $this->em->getRepository(Admin::class)->findOneBy(['username' => $user->getUsername()])) {
            $userLocal = new Admin();
            $userLocal->setUsername($user->getUsername());
            $this->em->persist($userLocal);
            $this->em->flush();
        } else {
            //$data = (array_merge($data, ['instances' => $userLocal->getInstances()]));
        }

        $event->setData($data);
    }
}
