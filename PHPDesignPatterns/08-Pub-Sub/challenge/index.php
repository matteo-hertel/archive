<?php

/**
 * Copyright (c) 2014 Keith Casey.
 *
 * This code is designed to accompany the lynda.com video course "Design Patterns in PHP"
 *   by Keith Casey. If you've received this code without seeing the videos, go watch the
 *   videos. It will make way more sense and be more useful in general.
 */
include_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;

$i = 0;
$dispatcher = new EventDispatcher();

$listener = new Test\Listener();
$dispatcher->addListener('event', array($listener, 'onEvent'));

$dispatcher->dispatch('event', new Test\Component('Component A', $i++));
$dispatcher->dispatch('event', new Test\ComponentWithEvents('Component B', $i++));
$dispatcher->dispatch('event', new Test\Component('Component C', $i++));
$dispatcher->dispatch('event', new Test\Component('Component F', $i++));
