<?php

require 'vendor/autoload.php';

class MH_ConfigTest extends PHPUnit_Framework_TestCase {

    public function testConstructorNoFile() {

        $config = new \MH\MH_Config(__DIR__ . "test.json");

        $this->assertEquals(false, $config->_author);
        $this->assertEquals(false, $config->packageName);
    }

    public function testConstructorDefault() {

        $config = new \MH\MH_Config();

        $this->assertEquals("Matteo Hertel", $config->_author);
        $this->assertEquals("MH_config", $config->packageName);
    }

    public function testOverrideFalse() {
        $config = new \MH\MH_Config();

        $config->_author = "Test Testington";
        $this->assertEquals("Matteo Hertel", $config->_author);
    }

    public function testOverrideTrue() {

        $config = new \MH\MH_Config();
        $config->override = true;
        $config->_author = "Test Testington";
        $this->assertEquals("Test Testington", $config->_author);
    }

    public function testPublic() {
        $config = new \MH\MH_Config();
        $time = time();
        $config->lastUpdate = $time;

        $this->assertEquals($time, $config->lastUpdate);
    }

    public function testDestructor() {

        $config = new \MH\MH_Config(__DIR__ . "test.json");
        $time = time();
        $config->_destructorTime = $time;
        unset($config);
        sleep(5);

        $config2 = new \MH\MH_Config(__DIR__ . "test.json");
        $this->assertNotEquals($time, $config->_destructorTime);
    }

    public function testCleanUp() {
        if (file_exists(__DIR__ . "test.json")) {
            unlink(__DIR__ . "test.json");
        }

        $this->assertEquals(true, true);
    }

}
