<?php

namespace SimpleSAML\XML;

class Register {

	static $register = array(
		\SimpleSAML\XML\feidetest\NS::URI => '\SimpleSAML\XML\feidetest\NS',
		\SimpleSAML\XML\ds\NS::URI => '\SimpleSAML\XML\ds\NS',
		\SimpleSAML\XML\md\NS::URI => '\SimpleSAML\XML\md\NS',
		\SimpleSAML\XML\saml\NS::URI => '\SimpleSAML\XML\saml\NS',
		\SimpleSAML\XML\xs\NS::URI => '\SimpleSAML\XML\xs\NS',
		\SimpleSAML\XML\xsi\NS::URI => '\SimpleSAML\XML\xsi\NS',
	);


	public static function getPrefix($namespaceURI) {
		if (isset(self::$register[$namespaceURI])) {
			$ns = self::$register[$namespaceURI];
			return $ns::PREFIX;
		} else {
			return NULL;
		}
	}

	public static function resolveElement($namespaceURI, $localName) {
		return self::resolveInContext('element', $namespaceURI, $localName);
	}

	public static function resolveAttribute($namespaceURI, $localName) {
		return self::resolveInContext('attribute', $namespaceURI, $localName);
	}

	public static function resolveInContext($context, $namespaceURI, $localName) {
		if (!isset(self::$register[$namespaceURI])) {
			return NULL;
		}
		$ns = self::$register[$namespaceURI];

		if (!isset($ns::$$context)) {
			return NULL;
		}
		$ctx =& $ns::$$context;

		if (!isset($ctx[$localName])) {
			return NULL;
		}

		return $ctx[$localName];
	}

}
