<?php

namespace leafTracker\Http\Controllers;

use leafTracker\Helpers\Arr;
use leafTracker\Repositories\Contracts\PointInterface;
use leafTracker\Repositories\Contracts\PolylineInterface;

use Sabre\HTTP\RequestInterface;

class HomeController {

    private $fenom;
    private $collection;

    public function __construct(\Fenom $fenom, PointInterface $point, PolylineInterface $polyline) {
        $this->fenom = $fenom;

        $points = $point->getData();
        $polyline = $polyline->getData();

        $this->collection = [
            'data' => [
                'points' => $points,
                'polyline' => $polyline
            ],
            'hashes' => [
                'points' => Arr::getHash($points),
                'polyline' => Arr::getHash($polyline)
            ]
        ];
    }

    public function data(RequestInterface $request) {
        $body = json_decode($request->getBodyAsString(), TRUE);

        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($body['data'] as $key => $value) {
                if (Arr::getHash($this->collection['data'][$key]) === $value) {
                    $this->collection['data'][$key] = NULL;
                }
            }
        }

        return $this->collection;
    }

    public function __invoke() {
        return $this->fenom->fetch('home.tpl', $this->collection);
    }

}
