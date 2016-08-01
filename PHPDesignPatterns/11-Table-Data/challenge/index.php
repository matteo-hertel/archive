<?php

/**
 * Copyright (c) 2014 Keith Casey.
 *
 * This code is designed to accompany the lynda.com video course "Design Patterns in PHP"
 *   by Keith Casey. If you've received this code without seeing the videos, go watch the
 *   videos. It will make way more sense and be more useful in general.
 */
require __DIR__ . "/vendor/autoload.php";
$user = new \Db\user();


foreach ($user->loadAll() as $row) {
    echo $row['user_name'].'<br />';
}
//
 echo '<hr />';
//
$userData = $user->findById(2);

echo $userData["user_name"];
