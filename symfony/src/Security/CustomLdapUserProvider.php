<?php

namespace App\Security;

use App\Entity\Main\AppUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\LdapInterface;
use Symfony\Component\Ldap\Security\LdapUser;
use Symfony\Component\Ldap\Security\LdapUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomLdapUserProvider extends LdapUserProvider
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
        LdapInterface $ldap,
        string $baseDn,
        string $searchDn = null,
        string $searchPassword = null,
        array $defaultRoles = [],
        string $uidKey = null,
        string $filter = null,
        string $passwordAttribute = null,
        array $extraFields = []
    ) {
        $this->em = $em;
        parent::__construct($ldap, $baseDn, $searchDn, $searchPassword, $defaultRoles, $uidKey, $filter, $passwordAttribute, $extraFields);
    }

    protected function loadUser(string $identifier, Entry $entry): UserInterface
    {
        $user =  parent::loadUser($identifier, $entry);
        /** @var AppUser $localUser */
        $localUser = $this->em->getRepository(AppUser::class)->findOneBy(['username' => $user->getUserIdentifier()]);

        if ($localUser) {
            return new LdapUser(
                $user->getEntry(),
                $user->getUserIdentifier(),
                $user->getPassword(),
                $localUser->getRoles(),
                $user->getExtraFields()
            );
        }

        return $user;
    }
}
