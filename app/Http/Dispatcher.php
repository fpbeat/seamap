<?php

namespace leafTracker\Http;

use function FastRoute\simpleDispatcher;

use leafTracker\Exceptions\NotFoundException;
use leafTracker\Exceptions\NotAllowedException;
use leafTracker\Http\Response\ResponseHandler;
use Sabre\HTTP\Response;
use Sabre\HTTP\Sapi;

class Dispatcher {

    private $response = NULL;

    public function __construct($routes = []) {
        $this->dispatcher = simpleDispatcher($routes);

        register_shutdown_function([$this, 'output']);
    }

    public function onDispatch(callable $foundCallback) {
        $route = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($route[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                throw new NotFoundException('Not found', 404);
                break;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new NotAllowedException('Not Allowed', 405);
                break;

            case \FastRoute\Dispatcher::FOUND:
                $this->response = ResponseHandler::factory((new Response()), call_user_func($foundCallback, $route));
                break;
        }
    }

    public function onError(callable $errorCallback) {
        $this->response = ResponseHandler::factory((new Response()), call_user_func($errorCallback));
    }

    public function output() {
        if (!headers_sent() && $this->response !== NULL) {
            Sapi::sendResponse($this->response);
        }
    }
}