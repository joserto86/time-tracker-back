<?php

namespace App\Model;

class Instance
{
    private ?int $id = null;

    private ?string $url = null;

    private bool $added = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Instance
    {
        $this->id = $id;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): Instance
    {
        $this->url = $url;
        return $this;
    }

    public function isAdded(): bool
    {
        return $this->added;
    }

    public function setSetted(bool $setted): Instance
    {
        $this->setted = $setted;
        return $this;
    }


}
