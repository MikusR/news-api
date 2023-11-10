<?php

namespace App\Controllers;

use App\Api;
use App\Response;



class ArticleController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(array $vars): Response
    {
        return new Response(
            "article\\top-articles", [
                "articles" => $this->api->fetchTopNews(
                    $vars['category'] ?? $_GET['category'] ?? null,
                    $vars['keyword'] ?? null,
                    $vars['country'] ?? 'us'
                )
            ]
        );
    }

    public function search(): Response
    {
        if (!isset($_GET['keyword'])) {
            return new Response('error', []);
        }
        $keyword = $_GET['keyword'];
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        return new Response(
            "article\\results", [
                "articles" => $this->api->fetchEverything(
                    urlencode($keyword),
                    $from,
                    $to
                )
            ]
        );
    }
}