<?php

namespace leafTracker\Http\Response\Handlers;

class JsonHandler extends AbstractHandler {

    protected function setStatus() {
        $this->response->setStatus(200);
    }

    protected function setHeaders() {
        $this->response->setHeader('Content-type', 'application/json');
    }

    protected function setContent() {
        $this->response->setBody(json_encode($this->content));
    }
}