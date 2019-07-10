<?php

namespace leafTracker\Http\Response\Handlers;

class HtmlHandler extends AbstractHandler {

    protected function setStatus() {
        $this->response->setStatus(200);
    }

    protected function setHeaders() {
        $this->response->setHeader('Content-type', 'text/html');
    }

    protected function setContent() {
        $this->response->setBody($this->content);
    }
}