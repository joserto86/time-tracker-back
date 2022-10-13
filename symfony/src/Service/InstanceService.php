<?php

namespace App\Service;

use App\Entity\Glquery\GlIssue;
use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use Doctrine\ORM\EntityManagerInterface;

class InstanceService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAppUserInstance(Instance $instance, AppUser $user): ?AppUserInstance
    {
        return $this->em->getRepository(AppUserInstance::class)->findOneBy([
            'instance' => $instance,
            'appUser' => $user
        ]);
    }

    public function getAppUserInstanceByIssue(GlIssue $issue, AppUser $user): ?AppUserInstance
    {
        $instance = $this->em->getRepository(Instance::class)->findOneBy(['url' => $issue->getGlInstance()]);
        return $this->getAppUserInstance($instance, $user);
    }
}
