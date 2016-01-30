<?php

include "url.class.php";

class URLTest extends PHPUnit_Framework_TestCase {

    public function testSpaces() {

        $url = new MH_URL("http://matteohertel.com/2014/mh_ui javascript lib create dynamic ui elements");

        $this->assertEquals("http://matteohertel.com/2014/mh_ui-javascript-lib-create-dynamic-ui-elements", $url->seoFriendlyURL());
    }

    public function testBadCharacters() {

        $url = new MH_URL("http://m!a£t%t^e&o*h(e)r=t+e|l.com/");

        $this->assertEquals("http://matteohertel.com/", $url->seoFriendlyURL());
    }

    public function testNoUppercaseLetters() {

        $url = new MH_URL("HTTP://MATTEOHERTEL.COM");

        $this->assertRegExp("/[a-z]/", $url->seoFriendlyURL());
    }

}
