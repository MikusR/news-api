<?php

declare(strict_types=1);

namespace App;

use App\Models\Article;
use App\Models\ArticleCollection;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

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

        $query = http_build_query([
            "category" => $category,
            "q" => $keyword,
            "country" => $country,
            "apiKey" => $_ENV['NEWS_API_KEY']
        ]);

        return $this->buildArticles($this->client->get(self::TOP_HEADLINES_URL . $query));
    }

    public function fetchTopNewsDefault( $country = 'bbc-news'): ArticleCollection
    {

        $query = http_build_query([
            "sources" => $country,
            "apiKey" => $_ENV['NEWS_API_KEY']
        ]);

        return $this->buildArticles($this->client->get(self::TOP_HEADLINES_URL . $query));
    }

    public function fetchEverything(string $keyword, ?string $from, ?string $to): ArticleCollection
    {
        $query = http_build_query([
            "q" => $keyword,
            "from" => $from,
            "to" => $to,
            "language" => 'en',
            "sortBy" => 'popularity',
            "apiKey" => $_ENV['NEWS_API_KEY']
        ]);

        return $this->buildArticles($this->client->get(self::EVERYTHING_URL . $query));
    }

    public function buildArticles(ResponseInterface $response): ArticleCollection
    {
        $articles = new ArticleCollection();
        $data = json_decode((string)$response->getBody(), false);


        foreach ($data->articles as $article) {
            $articles->add(
                new Article(
                    $article->source->name,
                    $article->author,
                    $article->title,
                    $article->description,
                    $article->url,
                    $article->urlToImage ?? "blank.jpg",
                    $article->publishedAt,
                    $article->content,
                )
            );
        }
        return $articles;
    }
}