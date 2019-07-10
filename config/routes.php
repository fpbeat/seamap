<?php

use leafTracker\Http\Controllers\HomeController;
use leafTracker\Http\Controllers\ServiceController;

return [
    'web' => function (FastRoute\RouteCollector $route) {
        $route->addRoute('GET', '/', HomeController::class);

        $route->addRoute('POST', '/data', [HomeController::class, 'data']);
    }
];