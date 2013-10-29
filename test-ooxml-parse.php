#!/usr/bin/env php
<?php
require_once('SimpleSAML/_autoload.php');

if (!file_exists('ukfederation-metadata.xml')) {
	echo "ukfederation-metadata.xml does not exist. Download it from: http://metadata.ukfederation.org.uk/ukfederation-metadata.xml\n";
	exit(1);
}

$parser = new \SimpleSAML\OOXML\Parser();

echo "Loading ukfederation-metadata.xml\n";
$doc = new DOMDocument();
$doc->load('ukfederation-metadata.xml');

echo "Parsing...\n";
$e = $parser->parse($doc->documentElement);

echo "Serializing...\n";
$e_ser = serialize($e);

echo "Saving...\n";
file_put_contents('parsed.serialized', $e_ser);

echo "Saved parsed XML to parsed.serialized.\n";
