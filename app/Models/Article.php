<?php

declare(strict_types=1);

namespace App\Models;

class Article
{
    private ?string $source;
    private ?string $author;
    private ?string $title;
    private ?string $description;
    private ?string $url;
    private ?string $urlToImage;
    private ?string $publishedAt;
    private ?string $content;

    public function __construct(
        ?string $source,
        ?string $author,
        ?string $title,
        ?string $description,
        ?string $url,
        ?string $urlToImage,
        ?string $publishedAt,
        ?string $content
    ) {
        $this->source = $source;
        $this->author = $author;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->urlToImage = $urlToImage;
        $this->publishedAt = $publishedAt;
        $this->content = $content;
    }


    public function getSource(): ?string
    {
        return $this->source;
    }


    public function getAuthor(): ?string
    {
        return $this->author;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }


    public function getUrlToImage(): ?string
    {
        return $this->urlToImage;
    }


    public function getPublishedAt(): ?string
    {
        return $this->publishedAt;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }
}