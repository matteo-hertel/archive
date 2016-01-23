<?php

/**
 * Copyright (c) 2014 Keith Casey
 *
 * This code is designed to accompany the lynda.com video course "Design Patterns in PHP"
 *   by Keith Casey. If you've received this code without seeing the videos, go watch the
 *   videos. It will make way more sense and be more useful in general.
 */

include_once __DIR__ . '/vendor/autoload.php';
include_once 'posts.php';

echo"<pre style='color:#59E817; background-color:black; word-wrap:break-word;'>";
var_dump(Post::first());
echo"</pre>";

// $post = new Post();
//
// $post->title = 'Sample Title';
// $post->body = 'This is the body';
//
// $post->save();
