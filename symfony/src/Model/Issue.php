<?php

namespace App\Model;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Issue implements TimeTrackerModelInterface
{
    private ?int $id = null;

    private ?string $glInstance = null;

    private ?int $glInstanceGroup = null;

    private ?int $glIid = null;

    private ?int $glProjectId = null;

    private ?string $glProject = null;

    private ?string $glNamespace = null;

    private ?string $glMilestone = null;

    private ?string $title = null;

    private ?string $description = null;

    private ?string $state = null;

    private ?\DateTimeInterface $createdAt = null;

    private ?\DateTimeInterface $updatedAt = null;

    private ?string $assignee = null;

    private ?string $author = null;

    private ?string $data = null;

    private ?int $glId = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Issue
     */
    public function setId(?int $id): Issue
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlInstance(): ?string
    {
        return $this->glInstance;
    }

    /**
     * @param string|null $glInstance
     * @return Issue
     */
    public function setGlInstance(?string $glInstance): Issue
    {
        $this->glInstance = $glInstance;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGlInstanceGroup(): ?int
    {
        return $this->glInstanceGroup;
    }

    /**
     * @param int|null $glInstanceGroup
     * @return Issue
     */
    public function setGlInstanceGroup(?int $glInstanceGroup): Issue
    {
        $this->glInstanceGroup = $glInstanceGroup;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGlIid(): ?int
    {
        return $this->glIid;
    }

    /**
     * @param int|null $glIid
     * @return Issue
     */
    public function setGlIid(?int $glIid): Issue
    {
        $this->glIid = $glIid;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGlProjectId(): ?int
    {
        return $this->glProjectId;
    }

    /**
     * @param int|null $glProjectId
     * @return Issue
     */
    public function setGlProjectId(?int $glProjectId): Issue
    {
        $this->glProjectId = $glProjectId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlProject(): ?string
    {
        return $this->glProject;
    }

    /**
     * @param string|null $glProject
     * @return Issue
     */
    public function setGlProject(?string $glProject): Issue
    {
        $this->glProject = $glProject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlNamespace(): ?string
    {
        return $this->glNamespace;
    }

    /**
     * @param string|null $glNamespace
     * @return Issue
     */
    public function setGlNamespace(?string $glNamespace): Issue
    {
        $this->glNamespace = $glNamespace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlMilestone(): ?string
    {
        return $this->glMilestone;
    }

    /**
     * @param string|null $glMilestone
     * @return Issue
     */
    public function setGlMilestone(?string $glMilestone): Issue
    {
        $this->glMilestone = $glMilestone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Issue
     */
    public function setTitle(?string $title): Issue
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Issue
     */
    public function setDescription(?string $description): Issue
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     * @return Issue
     */
    public function setState(?string $state): Issue
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return Issue
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): Issue
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return Issue
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Issue
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    /**
     * @param string|null $assignee
     * @return Issue
     */
    public function setAssignee(?string $assignee): Issue
    {
        $this->assignee = $assignee;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Issue
     */
    public function setAuthor(?string $author): Issue
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @param string|null $data
     * @return Issue
     */
    public function setData(?string $data): Issue
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGlId(): ?int
    {
        return $this->glId;
    }

    /**
     * @param int|null $glId
     * @return Issue
     */
    public function setGlId(?int $glId): Issue
    {
        $this->glId = $glId;
        return $this;
    }
}
