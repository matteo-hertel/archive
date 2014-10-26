<?php

require 'vendor/autoload.php';

class MH_ConfigTest extends PHPUnit_Framework_TestCase {

    public function testConstructor() {

        $configTest = new MH_Config();

        $this->assertEquals("object", gettype($configTest));
    }

}
