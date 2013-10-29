#!/usr/bin/env php
<?php
require_once('SimpleSAML/_autoload.php');

$doc = new DOMDocument();
$doc->load('assertion.xml');
$assertion = new \SimpleSAML\XML\saml\Assertion($doc->documentElement);

echo "var_export:\n";
var_export($assertion);
echo "\n\n";

$doc = new DOMDocument();
$e = $assertion->toXML($doc);
echo "XML:\n";
echo $e->ownerDocument->saveXML($e), "\n";
