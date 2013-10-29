#!/usr/bin/env php
<?php
require_once('SimpleSAML/_autoload.php');

if (!file_exists('ukfederation-metadata.xml')) {
	echo "ukfederation-metadata.xml does not exist. Download it from: http://metadata.ukfederation.org.uk/ukfederation-metadata.xml\n";
	exit(1);
}

$doc = new DOMDocument();
$doc->load('ukfederation-metadata.xml');

$e = new \SimpleSAML\XML\md\EntitiesDescriptor($doc->documentElement);
foreach ($e->EntityDescriptor as $ed) {
	echo $ed->entityID . "\n";
}
