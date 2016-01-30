<?php

require '../vendor/autoload.php';

class MH_matrixTest extends PHPUnit_Framework_TestCase {

    public function testMatrix2x2() {

        $matrix1 = new MH_matrix(2, 2); //2

        $this->assertEquals(2, $matrix1->processMatrix()->result());
    }

    public function testMatrix4x4() {

        $matrix2 = new MH_matrix(4, 4); //20

        $this->assertEquals(20, $matrix2->processMatrix()->result());
    }

    public function testMatrix6x6() {

        $matrix3 = new MH_matrix(6, 6); //252

        $this->assertEquals(252, $matrix3->processMatrix()->result());
    }

    public function testMatrix7x7() {

        $matrix4 = new MH_matrix(7, 7); //924

        $this->assertEquals(924, $matrix4->processMatrix()->result());
    }

    public function testMatrix6x3() {

        $matrix5 = new MH_matrix(6, 3); //21

        $this->assertEquals(21, $matrix5->processMatrix()->result());
    }

    public function testMatrix2x6() {

        $matrix6 = new MH_matrix(2, 6); //6

        $this->assertEquals(6, $matrix6->processMatrix()->result());
    }

}
