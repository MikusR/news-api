<?php

declare(strict_types=1);

use app\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app->run();