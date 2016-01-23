<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as Dispatcher;
use Illuminate\Container\Container as Container;


class Post extends Eloquent {

    protected $fillable = ["title", "body"];


    public function __construct(){
        $capsule = new Capsule();


        $capsule->addConnection([
            "driver"    => "mysql",
            "host"      => "localhost",
            "database"  => "designpatternscourse",
            "username"  => "homestead",
            "password"  => "secret",
            "charset"   => "utf8",
            "collation" => "utf8_general_ci",
            "prefix"    => ""
            ]);

            $capsule->setEventDispatcher(new Dispatcher(new Container));
            $capsule->bootEloquent();
    }
}
