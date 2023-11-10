<?php

namespace App\Controllers;

use App\Api;
use App\Response;
use ReflectionClass;


class ArticleController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(array $vars): Response
    {
        echo("Hello from " . (new ReflectionClass($this))->getShortName());
        return new Response(
            "article\\top-articles", [
                "articles" => $this->api->fetchTopNews(
                    $vars['category'] ?? null,
                    $vars['keyword'] ?? null,
                    $vars['country'] ?? 'us'
                )
            ]
        );
    }
}