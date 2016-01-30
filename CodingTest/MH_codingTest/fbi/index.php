<?php

require 'vendor/autoload.php';

// init the organisation
$mafia = new Mafia();


//new Boss
$boss1 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Boss1", 
    "age" => 60));
//new Boss
$boss2 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Boss2", 
    "age" => 60));

//add boss 1 & 2 to the organisation
$mafia->addBoss($boss1)->addBoss($boss2);

$sub1 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Member1", 
    "age" => 50));

$sub2 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Member2", 
    "age" => 50));

$sub3 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Member3", 
    "age" => 39));

$sub4 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Member4", 
    "age" => 45));

$sub5 = new MafiaMember(array(
    "active" => true, 
    "free" => true,
    "name" => "Member5", 
    "age" => 25));
    
$boss1->addSubordinate($sub1)->addSubordinate($sub2->addSubordinate($sub3->addSubordinate($sub4->addSubordinate($sub5))));


echo "<h2>Full Organisation</h2>";
$mafia->printOrganisation();

$sub2->arrested();

$sub3->arrested();
$sub2->released($mafia);
echo "<h2>Organisation after some arrests and release</h2>";
$mafia->printOrganisation();

$sub3->released($mafia);
$sub3->killed();
echo "<h2>Organisation with killed memeber</h2>";
$mafia->printOrganisation();



