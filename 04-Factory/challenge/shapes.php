<?php
namespace Shapes;

class Shape{

    public static function getShape($name, $dimension){
        $className = sprintf("\Shapes\%s", ucwords($name));

        if (class_exists($className)){
            return new $className($dimension);
        }

        throw new \Exception("Unrecognized Shape in Shapes namespace", 1);

    }
}

class Circle {

    protected $radius;

    public function __construct($radius){
        $this->radius = (int)$radius;
    }

    public function getArea(){
            return  pi() * $this->radius * $this->radius;
    }

}

class Square {

    protected $sides;

    public function __construct($sides){

        $this->sides = (int) $sides;
    }

    public function getArea(){
        return $this->sides * $this->sides;
    }

}
