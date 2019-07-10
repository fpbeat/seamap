<?php

namespace leafTracker\Http\Response\Handlers;

use Sabre\HTTP\Response;

abstract class AbstractHandler {

    protected $response;
    protected $content;

    public function __construct(Response $response, $content) {
        $this->response = $response;
        $this->content = $content;
    }

    function __invoke() {
        $this->setStatus();
        $this->setHeaders();
        $this->setContent();

        return $this->response;
    }

    protected abstract function setStatus();

    protected abstract function setHeaders();

    protected abstract function setContent();
}