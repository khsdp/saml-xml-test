#!/usr/bin/env php
<?php
require_once('SimpleSAML/_autoload.php');

if (!file_exists('parsed.serialized')) {
	echo "parsed.serialized does not exist. Run test-ooxml-parse.php first.\n";
	exit(1);
}

echo "Loading parsed.serialized...\n";
$e = file_get_contents('parsed.serialized');

echo "Unserializing...\n";
$e = unserialize($e);



echo "Serializing to XML...\n";
$serializer = new \SimpleSAML\OOXML\Serializer();
$startSer = microtime(true);
$xe = $serializer->serialize($e);
$endSer = microtime(true);
echo 'Serialized XML in ' . ($endSer - $startSer) . ' seconds.' . "\n";

file_put_contents('ooxml-serialize.xml', $xe);
echo "Wrote XML to: ooxml-serialize.xml\n";
