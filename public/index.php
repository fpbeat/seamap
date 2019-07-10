<?php

use leafTracker\Http\Dispatcher;
use leafTracker\Exceptions\DispatcherException;

define('DOCROOT', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
$container = require DOCROOT . 'bootstrap/app.php';

try {
    $container->get(Dispatcher::class)->onDispatch(function ($route) use ($container) {
        return $container->call($route[1], $route[2]);
    });

} catch (DispatcherException $e) {
    $container->get(Dispatcher::class)->onError(function () use ($e, $container) {
        $container->get(Fenom::class)->fetch(sprintf('errors/%d.tpl', $e->getCode()));
    });

} catch (Exception $e) {
    echo $e->getMessage();
}