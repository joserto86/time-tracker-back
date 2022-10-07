<?php

namespace App\Model;

use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
class GlMilestone implements TimeTrackerModelInterface
{
    private int $id;

    private int $iId;

    private int $projectId;

    private string $title;

    private ?string $description;

    private ?string $state;

    private ?\DateTimeInterface $createdAt;

    private ?\DateTimeInterface $updatedAt;

    private ?\DateTimeInterface $dueDate;

    private ?\DateTimeInterface $startDate;

    private ?bool $expired;

    private ?string $webUrl;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): GlMilestone
    {
        $this->id = $id;
        return $this;
    }

    public function getIId(): int
    {
        return $this->iId;
    }

    public function setIId(int $iId): GlMilestone
    {
        $this->iId = $iId;
        return $this;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): GlMilestone
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): GlMilestone
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): GlMilestone
    {
        $this->description = $description;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): GlMilestone
    {
        $this->state = $state;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): GlMilestone
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): GlMilestone
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): GlMilestone
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): GlMilestone
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getExpired(): ?bool
    {
        return $this->expired;
    }

    public function setExpired(?bool $expired): GlMilestone
    {
        $this->expired = $expired;
        return $this;
    }

    public function getWebUrl(): ?string
    {
        return $this->webUrl;
    }

    public function setWebUrl(?string $webUrl): GlMilestone
    {
        $this->webUrl = $webUrl;
        return $this;
    }
}
