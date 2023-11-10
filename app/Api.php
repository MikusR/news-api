<?php

declare(strict_types=1);

namespace App;

use App\Models\Article;
use App\Models\ArticleCollection;
use GuzzleHttp\Client;

class Api
{
    private Client $client;
    private const TOP_HEADLINES_URL = "https://newsapi.org/v2/top-headlines?";
    private const EVERYTHING_URL = "https://newsapi.org/v2/everything?";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchTopNews(?string $category, ?string $keyword, ?string $country = 'us'): ArticleCollection
    {
        $articles = new ArticleCollection();
        $query = http_build_query([
            "category" => $category,
            "q" => $keyword,
            "country" => $country,
            "apiKey" => $_ENV['NEWS_API_KEY']
        ]);
        $response = $this->client->get(self::TOP_HEADLINES_URL . $query);

        $data = json_decode((string)$response->getBody());

        foreach ($data->articles as $article) {
            $articles->add(
                new Article(
                    $article->source->name,
                    $article->author,
                    $article->title,
                    $article->description,
                    $article->url,
                    $article->urlToImage,
                    $article->publishedAt,
                    $article->content,
                )
            );
        }
        return $articles;
    }
}