<?php
namespace Test;
use Symfony\Component\EventDispatcher\Event;

class listener
{

    public function onEvent(Event $event)
    {
        $event->addOneAndEcho();
    }
}
