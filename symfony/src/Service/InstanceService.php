<?php

namespace App\Service;

use App\Entity\Glquery\GlIssue;
use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

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

    public function update(AppUser $user, Instance $instance, ParameterBag $data) :AppUserInstance
    {
        try {
            $persist = false;

            $entity = $this->getAppUserInstance($instance, $user);
            if (!$entity) {
                $entity = new AppUserInstance();
                $entity->setUsername($user->getUsername());
                $user->addAppUserInstance($entity);
                $this->em->persist($user);
                $persist = true;
            }

            if ($data->has('token')) {
                $entity->setToken($data->get('token'));
                $persist = true;
            }

            if ($data->has('username')) {
                $entity->setUsername($data->get('username'));
                $persist = true;
            }

            if ($persist) {
                $this->em->persist($entity);
                $this->em->flush();
            }

            return $entity;
        } catch (\Exception $e) {
            throw new \LogicException('Invalid Request Params', Response::HTTP_BAD_REQUEST);
        }
    }
}
