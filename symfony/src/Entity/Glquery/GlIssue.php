<?php

namespace App\Entity\Glquery;

use App\Repository\Glquery\GlIssueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlIssueRepository::class)]
#[ORM\Table(name: 'gl_issues')]
#[ORM\Index(name: 'instance', columns: ['gl_instance'])]
#[ORM\Index(name: 'instance_group', columns: ['gl_instance_group'])]
#[ORM\Index(name: 'author', columns: ['author'])]
#[ORM\Index(name: 'assignee', columns: ['assignee'])]
#[ORM\Index(name: 'updated_at', columns: ['updated_at'])]
#[ORM\Index(name: 'created_at', columns: ['created_at'])]
#[ORM\Index(name: 'state', columns: ['state'])]
#[ORM\Index(name: 'description', columns: ['description'])]
#[ORM\Index(name: 'title', columns: ['title'])]
#[ORM\Index(name: 'projectiid', columns: ['gl_project_id'])]
#[ORM\Index(name: 'idd', columns: ['gl_iid'])]
class GlIssue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $glInstance = null;

    #[ORM\Column]
    private ?int $glInstanceGroup = null;

    #[ORM\Column]
    private ?int $glIid = null;

    #[ORM\Column]
    private ?int $glProjectId = null;

    #[ORM\Column(length: 500)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $assignee = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
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
