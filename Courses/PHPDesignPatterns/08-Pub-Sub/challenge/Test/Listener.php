<?php

namespace Test;

use Symfony\Component\EventDispatcher\Event;

class Listener
{
    public function onEvent(Event $event)
    {
        $event->addOneAndEcho();
    }
}
