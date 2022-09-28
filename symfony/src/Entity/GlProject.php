<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\GlProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlProjectRepository::class)]
#[ORM\Table(name: 'gl_projects')]
#[ORM\Index(name: 'instance_group', columns: ['gl_instance_group'])]
#[ORM\Index(name: 'namespace', columns: ['namespace'])]
#[ORM\Index(name: 'name', columns: ['name'])]
#[ORM\Index(name: 'glid', columns: ['gl_id'])]
#[ORM\Index(name: 'instance', columns: ['gl_instance'])]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/project/{id}',
        requirements: ['id' => '\d+'],
    ),
    new GetCollection(
        name: 'list',
        routeName: 'project-list'
    ),
    new GetCollection(
        name: 'issue-list',
        routeName: 'project-issue-list'
    ),
    new GetCollection(
        name: 'time-note-list',
        routeName: 'project-time-note-list',
    )
])]
class GlProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $glInstance = null;

    #[ORM\Column]
    private ?int $glId = null;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 200)]
    private ?string $namespace = null;

    #[ORM\Column]
    private ?\DateTime $lastActivityAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    private ?int $glInstanceGroup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGlInstance(): ?string
    {
        return $this->glInstance;
    }

    public function setGlInstance(string $glInstance): self
    {
        $this->glInstance = $glInstance;

        return $this;
    }

    public function getGlId(): ?int
    {
        return $this->glId;
    }

    public function setGlId(int $glId): self
    {
        $this->glId = $glId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getLastActivityAt(): ?\DateTime
    {
        return $this->lastActivityAt;
    }

    public function setLastActivityAt(\DateTime $lastActivityAt): self
    {
        $this->lastActivityAt = $lastActivityAt;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getGlInstanceGroup(): ?int
    {
        return $this->glInstanceGroup;
    }

    public function setGlInstanceGroup(int $glInstanceGroup): self
    {
        $this->glInstanceGroup = $glInstanceGroup;

        return $this;
    }
}
