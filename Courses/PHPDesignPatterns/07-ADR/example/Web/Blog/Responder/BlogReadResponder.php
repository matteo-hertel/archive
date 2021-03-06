<?php

namespace Blog\Responder;

class BlogReadResponder extends AbstractBlogResponder
{
    protected $available = array(
        'text/html' => '',
        'application/json' => '.json',
    );

    protected $payload_method = array(
        'Domain\Payload\Found' => 'found',
        'Domain\Payload\NotFound' => 'notFound',
    );

    protected function found()
    {
        if ($this->negotiateMediaType()) {
            $this->renderView('read');
        }
    }
}
