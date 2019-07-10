<?php

namespace leafTracker\Http\Response;

use Sabre\HTTP\Response;

class ResponseHandler {

    public static function factory(Response $response, $content) {
        switch (gettype($content)) {
            case 'array':
                $handler = '\leafTracker\Http\Response\Handlers\JsonHandler';
                break;
            default:
                $handler = '\leafTracker\Http\Response\Handlers\HtmlHandler';
        }

        return call_user_func(new $handler($response, $content));
    }
}