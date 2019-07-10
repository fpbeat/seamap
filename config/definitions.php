<?php

use leafTracker\Helpers\Url;
use leafTracker\Http\Dispatcher;

use leafTracker\Entities\PointEntity;
use leafTracker\Entities\PolylineEntity;

use leafTracker\Repositories\PointEntityRepository;
use leafTracker\Repositories\PolylineEntityRepository;

use leafTracker\Repositories\Contracts\PointInterface;
use leafTracker\Repositories\Contracts\PolylineInterface;

use Noodlehaus\Config;
use Spot\Locator;

return [
    Fenom::class => function () {
        $fenom = Fenom::factory(DOCROOT . 'resources/views', sys_get_temp_dir(), Config::load(DOCROOT . 'config/app.php')->get('fenom', []));

        $fenom->addFunction('abspath', function ($params) {
            return Url::getBaseUrl($params['path']);
        });

        return $fenom;
    },

    Dispatcher::class => function () {
        return new leafTracker\Http\Dispatcher(Config::load(DOCROOT . 'config/routes.php')->get('web'));
    },

    Locator::class => function () {
        $cfg = new Spot\Config();
        $cfg->addConnection('default', Config::load(DOCROOT . 'config/database.php')->get('mysql'));

        return (new Locator($cfg));
    },

    Sabre\HTTP\RequestInterface::class => function () {
        return Sabre\HTTP\Sapi::getRequest();
    },

    PointInterface::class => DI\create(PointEntityRepository::class)->constructor(DI\get(PointEntity::class), Di\get(Locator::class)),
    PolylineInterface::class => DI\create(PolylineEntityRepository::class)->constructor(DI\get(PolylineEntity::class), Di\get(Locator::class))
];