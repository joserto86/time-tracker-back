<?php

namespace App\Entity\Glquery;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Glquery\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\Index(columns: ['instance'], name: 'instance')]
#[ORM\Index(columns: ['username'], name: 'username')]
#[ORM\Index(columns: ['name'], name: 'name')]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/user/{id}',
        requirements: ['id' => '\d+'],
    ),
    new GetCollection(
        routeName: 'user-list',
        name: 'list'
    ),
    new GetCollection(
        routeName: 'user-project-list',
        read: 'id',
        name: 'project-list'
    )
])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 200)]
    private ?string $username = null;

    #[ORM\Column(length: 200)]
    private ?string $instance = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $team = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getInstance(): ?string
    {
        return $this->instance;
    }

    public function setInstance(string $instance): self
    {
        $this->instance = $instance;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(?string $team): self
    {
        $this->team = $team;

        return $this;
    }
}
