<?php

namespace App\Model;

class Filter
{
    private string $id;

    private string $name;

    private string $column;

    private string $condition;

    private ?string $searchTerm;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Filter
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Filter
    {
        $this->name = $name;
        return $this;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function setColumn(string $column): Filter
    {
        $this->column = $column;
        return $this;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function setCondition(string $condition): Filter
    {
        $this->condition = $condition;
        return $this;
    }

    public function getSearchTerm(): ?string
    {
        return $this->searchTerm;
    }

    public function setSearchTerm(?string $searchTerm): Filter
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    public function isValid(): bool {
        return !empty($this->id) &&
            !empty($this->name) &&
            !empty($this->column) &&
            !empty($this->condition);
    }
}
