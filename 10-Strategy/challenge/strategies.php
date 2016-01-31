<?php

class NumberFilter{

    protected $filterStrategy;

    public function __construct($filterStrategy){
            $this->filterStrategy = $filterStrategy;
    }
    public function filter($data){
            return $this->filterStrategy->filter($data);
    }

}

class EvenStrategy{

    public function filter($data){
            return is_numeric($data) && $data % 2 === 0;
    }

}
class OddStrategy{

    public function filter($data){
            return is_numeric($data) && $data % 2 !== 0;
    }

}
