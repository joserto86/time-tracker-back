<?php

namespace App\Model;

class TimeNote implements TimeTrackerModelInterface
{
    protected ?string $body;

    protected int $timeSeconds;

    protected ?\DateTimeInterface $date;

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): TimeNote
    {
        $this->body = $body;
        return $this;
    }

    public function getTimeSeconds(): int
    {
        return $this->timeSeconds;
    }

    public function setTimeSeconds(int $timeSeconds): TimeNote
    {
        $this->timeSeconds = $timeSeconds;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): TimeNote
    {
        $this->date = $date;
        return $this;
    }
}
