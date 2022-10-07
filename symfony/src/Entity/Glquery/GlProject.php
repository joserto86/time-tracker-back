<?php

namespace App\Entity\Glquery;

use App\Repository\Glquery\GlProjectRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GlProjectRepository::class)]
#[ORM\Table(name: 'gl_projects')]
#[ORM\Index(columns: ['gl_instance_group'], name: 'instance_group')]
#[ORM\Index(columns: ['namespace'], name: 'namespace')]
#[ORM\Index(columns: ['name'], name: 'name')]
#[ORM\Index(columns: ['gl_id'], name: 'glid')]
#[ORM\Index(columns: ['gl_instance'], name: 'instance')]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/project/{id}',
        requirements: ['id' => '\d+'],
    ),
    new GetCollection(
        routeName: 'project-list',
        name: 'list'
    ),
    new GetCollection(
        routeName: 'project-issue-list',
        name: 'issue-list'
    ),
    new GetCollection(
        routeName: 'project-time-note-list',
        name: 'time-note-list',
    )
])]
class GlProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Groups(['list'])]
    private ?string $glInstance = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glId = null;

    #[ORM\Column(length: 200)]
    #[Groups(['list'])]
    private ?string $name = null;

    #[ORM\Column(length: 200)]
    #[Groups(['list'])]
    private ?string $namespace = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?\DateTime $lastActivityAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    #[Groups(['list'])]
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
