<?php

namespace App\Entity;

use App\Repository\GlTimeNoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlTimeNoteRepository::class)]
#[ORM\Table(name: 'gl_time_notes')]
#[ORM\Index(name: 'spent_at', columns: ['spent_at'])]
#[ORM\Index(name: 'updated_at', columns: ['updated_at'])]
#[ORM\Index(name: 'created_at', columns: ['created_at'])]
#[ORM\Index(name: 'gl_project_id', columns: ['gl_project_id'])]
#[ORM\Index(name: 'gl_iid', columns: ['gl_id'])]
#[ORM\Index(name: 'gl_instance', columns: ['gl_instance'])]
class GlTimeNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $glInstance = null;

    #[ORM\Column]
    private ?int $glId = null;

    #[ORM\Column]
    private ?int $glProjectId = null;

    #[ORM\Column]
    private ?int $glIssueId = null;

    #[ORM\Column(length: 200)]
    private ?string $body = null;

    #[ORM\Column(length: 200)]
    private ?string $author = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $secondsAdded = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?int $secondsSubtracted = null;

    #[ORM\Column(type: Types::BOOLEAN , nullable: true)]
    private ?string $secondsRemoved = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $spentAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    private ?int $glIssueIid = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
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
