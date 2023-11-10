<?php

declare(strict_types=1);

namespace App\Models;

class ArticleCollection
{
    /**
     * @var Article[]
     */
    private array $articles;

    public function __construct(array $articles = [])
    {
        $this->articles = $articles;
    }

    public function add(Article $article): void
    {
        $this->articles[] = $article;
    }

    public function list(): array
    {
        return $this->articles;
    }
}