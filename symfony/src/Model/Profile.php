<?php

namespace App\Model;

class Profile
{
    private string $defaultView;

    private array $defaultColumns;


    public function __construct()
    {
        $this->defaultColumns = [];
    }

    public function getDefaultView(): string
    {
        return $this->defaultView;
    }

    public function setDefaultView(string $defaultView): Profile
    {
        $this->defaultView = $defaultView;
        return $this;
    }

    public function getDefaultColumns(): array
    {
        return $this->defaultColumns;
    }

    public function setDefaultColumns(array $defaultColumns): Profile
    {
        $this->defaultColumns = $defaultColumns;
        return $this;
    }

    public function isValid(): bool
    {
        return !empty($this->defaultView) &&
            !empty($this->defaultColumns);
    }
}
