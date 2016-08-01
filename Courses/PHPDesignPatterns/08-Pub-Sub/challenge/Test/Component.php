<?php

namespace Test;

use Symfony\Component\EventDispatcher\Event;

class Component extends Event
{
    protected $name = '';
    protected $i;
    public function __construct($name, $i)
    {
        $this->name = $name;
        $this->i = $i;
    }

    public function addOneAndEcho()
    {
        ++$this->i;
        echo $this->i.'-'.$this->name.'<br />';
    }
}
class ComponentWithEvents extends Event
{
    protected $name = '';
    protected $i;
    public function __construct($name, $i)
    {
        $this->name = $name;
        $this->i = $i;
    }

    public function addOneAndEcho()
    {
        ++$this->i;
        echo $this->i.'-'.$this->name.'<br />';
        $this->fireEvent();
    }

    private function fireEvent()
    {
        global $dispatcher;

        $dispatcher->dispatch('event', new Component('Component D', 20));
        $dispatcher->dispatch('event', new Component('Component E', 21));
    }
}
