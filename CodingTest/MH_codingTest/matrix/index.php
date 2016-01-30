<?php

require 'vendor/autoload.php';
/*
 * New matrix
 */
$matrix = new MH_matrix(7, 5);
/*
 * process the matrix
 */
$matrix->processMatrix();
/*
 * print out the representation of the matrix
 */
$matrix->printTable();
echo "<hr />";
/*
 * print the result
 */
echo sprintf("There are %s different paths", $matrix->result());


