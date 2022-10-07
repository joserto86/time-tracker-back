<?php

namespace App\Entity\Glquery;

use App\Repository\Glquery\GlIssueRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GlIssueRepository::class)]
#[ORM\Table(name: 'gl_issues')]
#[ORM\Index(columns: ['gl_instance'], name: 'instance')]
#[ORM\Index(columns: ['gl_instance_group'], name: 'instance_group')]
#[ORM\Index(columns: ['author'], name: 'author')]
#[ORM\Index(columns: ['assignee'], name: 'assignee')]
#[ORM\Index(columns: ['updated_at'], name: 'updated_at')]
#[ORM\Index(columns: ['created_at'], name: 'created_at')]
#[ORM\Index(columns: ['state'], name: 'state')]
#[ORM\Index(columns: ['description'], name: 'description')]
#[ORM\Index(columns: ['title'], name: 'title')]
#[ORM\Index(columns: ['gl_project_id'], name: 'projectiid')]
#[ORM\Index(columns: ['gl_iid'], name: 'idd')]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/issue/{id}',
        requirements: ['id' => '\d+'],
    ),
    new GetCollection(
        routeName: 'issue-list',
        name: 'list'
    ),
    new GetCollection(
        routeName: 'issue-time-note-list',
        name: 'time-note-list'
    )
])]
class GlIssue
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
    private ?int $glInstanceGroup = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glIid = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glProjectId = null;

    #[ORM\Column(length: 500)]
    #[Groups(['list'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(['list'])]
    private ?string $state = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(['list'])]
    private ?string $assignee = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(['list'])]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glId = null;

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

    public function getGlInstanceGroup(): ?int
    {
        return $this->glInstanceGroup;
    }

    public function setGlInstanceGroup(int $glInstanceGroup): self
    {
        $this->glInstanceGroup = $glInstanceGroup;

        return $this;
    }

    public function getGlIid(): ?int
    {
        return $this->glIid;
    }

    public function setGlIid(int $glIid): self
    {
        $this->glIid = $glIid;

        return $this;
    }

    public function getGlProjectId(): ?int
    {
        return $this->glProjectId;
    }

    public function setGlProjectId(int $glProjectId): self
    {
        $this->glProjectId = $glProjectId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function setAssignee(?string $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

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

    public function getGlId(): ?int
    {
        return $this->glId;
    }

    public function setGlId(int $glId): self
    {
        $this->glId = $glId;

        return $this;
    }
}
