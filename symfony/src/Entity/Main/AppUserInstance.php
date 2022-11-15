<?php

namespace App\Entity\Main;

use App\Repository\Main\AppUserInstanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;

#[ORM\Entity(repositoryClass: AppUserInstanceRepository::class)]
class AppUserInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[ORM\JoinColumn(nullable: true)]
    #[Encrypted]
    private ?string $token = null;

    #[ORM\ManyToOne(inversedBy: 'AppUserInstances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instance $instance = null;

    #[ORM\ManyToOne(inversedBy: 'AppUserInstances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AppUser $appUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getInstance(): ?Instance
    {
        return $this->instance;
    }

    public function setInstance(?Instance $instance): self
    {
        $this->instance = $instance;

        return $this;
    }

    public function getAppUser(): ?AppUser
    {
        return $this->appUser;
    }

    public function setAppUser(?AppUser $appUser): self
    {
        $this->appUser = $appUser;

        return $this;
    }
}
