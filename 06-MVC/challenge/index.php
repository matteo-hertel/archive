<?php

/**
 * Copyright (c) 2014 Keith Casey.
 *
 * This code is designed to accompany the lynda.com video course "Design Patterns in PHP"
 *   by Keith Casey. If you've received this code without seeing the videos, go watch the
 *   videos. It will make way more sense and be more useful in general.
 */

/**
 * Suggested URL patterns for your solution:
 *      index.php?m=greeting&a=hello
 *      index.php?m=greeting&a=goodbye.
 */
define('URL', '/PHPDesignPatterns/06-MVC/challenge');

include __DIR__.'/controllers/MainController.php';

$controller = new MainController(filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING));

$controller->handle();
