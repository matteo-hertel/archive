<?php

require 'vendor/autoload.php';

$xml = new SimpleXMLIterator("http://feeds.bbci.co.uk/news/technology/rss.xml", NULL, TRUE);

echo json_encode(new MH_RSSChannel($xml->channel));
