<?php

namespace App\Helpers;

class Helpers {

    public static function createArrayRange($num = false){
        //create and array that holds values from 1 to 100 
        $arrayRange = range(1, 100);
        //if no number is passed return the array
        if(!$num){
            return $arrayRange;
        }
        //if we do have a number filter the array to remove the number passed
        $result = array_filter($arrayRange, function($item) use($num){
            if((int)$num === (int)$item){
                return false;
            }
                return true;
            });

        //return  the result
        return $result;
    }

    public static function findMissingNumber(array $array){
        //sort the array first to normalize it
        sort($array);
        //cache the length of the array
        $len = count($array);
        //loop through the array, if the missing number is found return it
        for($i = 0; $i < $len; $i++){
            if($array[$i] !== $i + 1){
                return $i + 1;
            }
        }
        return 0;
    }
}