<?php

declare(strict_types=1);

namespace App;

class Response
{
    private string $viewName;
    private array $articleData;

    public function __construct(string $viewName, array $articleData)
    {
        $this->viewName = $viewName;
        $this->articleData = $articleData;
    }


    public function view(): string
    {
        return $this->viewName;
    }

    public function articles(): array
    {
        return $this->articleData;
    }
}