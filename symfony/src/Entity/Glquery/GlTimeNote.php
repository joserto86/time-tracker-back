<?php

namespace App\Entity\Glquery;

use App\Repository\Glquery\GlTimeNoteRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GlTimeNoteRepository::class)]
#[ORM\Table(name: 'gl_time_notes')]
#[ORM\Index(columns: ['spent_at'], name: 'spent_at')]
#[ORM\Index(columns: ['updated_at'], name: 'updated_at')]
#[ORM\Index(columns: ['created_at'], name: 'created_at')]
#[ORM\Index(columns: ['gl_project_id'], name: 'gl_project_id')]
#[ORM\Index(columns: ['gl_id'], name: 'gl_iid')]
#[ORM\Index(columns: ['gl_instance'], name: 'gl_instance')]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/time-note/{id}',
        requirements: ['id' => '\d+'],
    ),
    new GetCollection(
        routeName: 'time-note-list',
        name: 'list'
    )
])]
class GlTimeNote
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

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glProjectId = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glIssueId = null;

    #[ORM\Column(length: 200)]
    #[Groups(['list'])]
    private ?string $body = null;

    #[ORM\Column(length: 200)]
    #[Groups(['list'])]
    private ?string $author = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    #[Groups(['list'])]
    private ?string $secondsAdded = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    #[Groups(['list'])]
    private ?int $secondsSubtracted = null;

    #[ORM\Column(type: Types::BOOLEAN , nullable: true)]
    #[Groups(['list'])]
    private ?string $secondsRemoved = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $spentAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $glIssueIid = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    #[Groups(['list'])]
    private ?int $computed = null;

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

    public function getGlProjectId(): ?int
    {
        return $this->glProjectId;
    }

    public function setGlProjectId(int $glProjectId): self
    {
        $this->glProjectId = $glProjectId;

        return $this;
    }

    public function getGlIssueId(): ?int
    {
        return $this->glIssueId;
    }

    public function setGlIssueId(int $glIssueId): self
    {
        $this->glIssueId = $glIssueId;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSecondsAdded(): ?string
    {
        return $this->secondsAdded;
    }

    public function setSecondsAdded(?string $secondsAdded): self
    {
        $this->secondsAdded = $secondsAdded;

        return $this;
    }

    public function getSecondsSubtracted(): ?int
    {
        return $this->secondsSubtracted;
    }

    public function setSecondsSubtracted(?int $secondsSubtracted): self
    {
        $this->secondsSubtracted = $secondsSubtracted;

        return $this;
    }

    public function isSecondsRemoved(): ?bool
    {
        return $this->secondsRemoved;
    }

    public function setSecondsRemoved(?bool $secondsRemoved): self
    {
        $this->secondsRemoved = $secondsRemoved;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSpentAt(): ?\DateTimeInterface
    {
        return $this->spentAt;
    }

    public function setSpentAt(\DateTimeInterface $spendAt): self
    {
        $this->spentAt = $spendAt;

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

    public function getGlIssueIid(): ?int
    {
        return $this->glIssueIid;
    }

    public function setGlIssueIid(int $glIssueIid): self
    {
        $this->glIssueIid = $glIssueIid;

        return $this;
    }

    public function getComputed(): ?int
    {
        return $this->computed;
    }

    public function setComputed(?int $computed): self
    {
        $this->computed = $computed;

        return $this;
    }
}
