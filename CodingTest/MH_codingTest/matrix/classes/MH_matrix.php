<?php

/**
 * Class to generate an x by y matrix
 *
 * The task was:
 * 
 * "Suppose you're on a N × M grid. Write a program that prints how 
 *  many different paths can you take to go from the bottom left to the top 
 *  right."
 * 
 * For readability purpose let's flip the grid, starting from the top-left
 * I need to arrive at the bottom-right.
 * 
 * Every cell in the first row take 1 step to arrive in, same for the first row.
 * To find the steps necessary to arrive in every other cell I can use the following formula:
 * 
 * cellValue = previousCellValue + PreviousRowCellValue
 * 
 *
 * @license    MIT
 * @version    0.1
 */
class MH_matrix {

    private $x, $y, $temp = array(), $matrix = array();

    /**
     * contructor
     * 
     * if two valid integer are passed the matrix can be
     * initialized
     *
     *
     * @param       int $x
     * @param       int $y
     */
    public function __construct($x, $y) {

        if (!is_int($x) || !is_int($y)) {
            throw new Exception("Only integers can be used to create a matrix", "0x001");
        }

        $this->x = $x;
        $this->y = $y;

        $this->buildMatrix();
    }

    /**
     * build the matrix
     * 
     * the matrix will be and array with x arrays of y length
     * the first array will be populate with 1 as value
     * all the others array will have the index 0 set as 1
     * and all others values to false
     *
     */
    private function buildMatrix() {
        for ($i = 0; $i < $this->y; $i++) {
            if ($i === 0) {
                for ($j = 0; $j < $this->x; $j++) {
                    $this->temp[] = 1;
                }
                $this->matrix[] = $this->temp;
                $this->temp = array();
            } else {
                for ($j = 0; $j < $this->x; $j++) {
                    if ($j === 0) {
                        $this->temp[] = 1;
                    } else {
                        $this->temp[] = false;
                    }
                }
                $this->matrix[] = $this->temp;
                $this->temp = array();
            }
        }
    }

    /**
     * populate all the missing value
     * 
     * pupulate the value previuosly set to false with the right
     * value using the formula
     * 
     * indexValue = previousIndexValue + PreviousArrayIndexValue
     *
     */
    public function processMatrix() {
        foreach ($this->matrix as $key => $array) {
            for ($i = 0; $i < count($array); $i++) {
                if ($array[$i] === false) {
                    $this->matrix[$key][$i] = $this->matrix[$key][$i - 1] + $this->matrix[$key - 1][$i];
                }
            }
        }

        return $this;
    }

    /*
     * result
     * 
     * return the result in other words
     * array x-1 at index y-1
     */

    public function result() {
        return $this->matrix[$this->y - 1][$this->x - 1];
    }

    /*
     * print the matrix
     * 
     * generate print out the html table that represent the matrix
     */

    public function printTable() {
        ob_start();
        echo '<table border="1" style="width:80%"><tbody>';

        foreach ($this->matrix as $key => $array) {
            echo "<tr>";
            for ($i = 0; $i < count($array); $i++) {
                echo sprintf("<td>%s</td>", $array[$i]);
            }
            echo "</tr>";
        }

        echo "</table></tbody>";
        echo ob_get_clean();
    }

    /*
     * magic getter
     * 
     * get the private "matrix" value
     */

    public function __get($name) {
        if ($name === "matrix") {
            return $this->matrix;
        }
    }

}
