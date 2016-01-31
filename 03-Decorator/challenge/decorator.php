<?php

class decorator
{
    public $sentence;

    public function lower()
    {
        return strtolower($this->sentence);
    }

    public function upperCase()
    {
        return strtoupper($this->sentence);
    }
}
