<?php

require '../vendor/autoload.php';

class MH_RSSChannelTest extends PHPUnit_Framework_TestCase {

    public function testValidRSSChannel() {

        $xml = new SimpleXMLIterator("http://feeds.bbci.co.uk/news/technology/rss.xml", NULL, TRUE);

        $test = new MH_RSSChannel($xml);
        $this->assertEquals(true, $test instanceof MH_RSSChannel);
    }

    public function testStringRatherThanObject() {
        try {
            $test = new MH_RSSChannel("String");
            $this->fail("Expected exception not thrown");
        } catch (Exception $exc) {
            $this->assertEquals("0x01", $exc->getCode());
        }
    }

    public function testChannelInstanceOfSimpleXMLElement() {

        $xml = new SimpleXMLElement("http://feeds.bbci.co.uk/news/technology/rss.xml", NULL, TRUE);

        try {
            $test = new MH_RSSChannel($xml);
            $this->fail("Expected exception not thrown");
        } catch (Exception $exc) {
            $this->assertEquals("0x01", $exc->getCode());
        }
    }

    public function testCreateChannel() {
        $xml = new SimpleXMLIterator("http://feeds.bbci.co.uk/news/technology/rss.xml", NULL, TRUE);

        $test = new MH_RSSChannel($xml->channel);

        $this->assertEquals(true, $test instanceof MH_RSSChannel);
    }

    public function testFinalTest() {
        $xml = new SimpleXMLIterator("http://feeds.bbci.co.uk/news/technology/rss.xml", NULL, TRUE);
        $test = new MH_RSSChannel($xml);
        $out = json_encode($test, JSON_PRETTY_PRINT);

        $this->assertNotNull(json_decode($out));
    }

}
