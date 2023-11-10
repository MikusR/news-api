<?php

declare(strict_types=1);

namespace App;

use Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use FastRoute;
use App\Controllers\IndexController;
use App\Controllers\ArticleController;

class Application
{
    public function run(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();
        $loader = new FilesystemLoader(__DIR__ . '/../app/Views');
        $twig = new Environment($loader, ['debug' => true]);
        $twig->addExtension(new DebugExtension());
        {
            $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
                $router->addRoute('GET', '/search', [ArticleController::class, 'search']);
                $router->addRoute('GET', '/country/[{country}]', [ArticleController::class, 'index']);
                $router->addRoute('GET', '/', [IndexController::class, 'index']);
            });

// Fetch method and URI from somewhere
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }
            $uri = rawurldecode($uri);

            $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
            switch ($routeInfo[0]) {
                case FastRoute\Dispatcher::NOT_FOUND:
                    // ... 404 Not Found
                    break;
                case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    // ... 405 Method Not Allowed
                    break;
                case FastRoute\Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    [$className, $method] = $handler;


                    $response = (new $className())->{$method}($vars);
                    $twig->addGlobal('countryFlag', $this->getFlag($vars['country'] ?? 'us'));
                    $twig->addGlobal('country', $vars['country'] ?? 'us');
                    $twig->addGlobal('category', $vars['category'] ?? $_GET['category'] ?? null);
                    $twig->addGlobal('keyword', $_GET['keyword'] ?? null);

                    echo $twig->render($response->view() . ".twig", $response->articles());


                    break;
            }
        }
    }

    public function getFlag(?string $country): string
    {
        switch ($country) {
            case 'lv':
                return '🇱🇻';
            case 'ua':
                return '🇺🇦';
            default:
                return '🇺🇸🇺🇸🇺🇸';
        }
    }
}
