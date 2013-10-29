<?php

namespace SimpleSAML\OOXML\UnPrefix;

class QName {

	public static function decode(\DOMElement $element, $value) {
		$decValue = explode(':', $value, 2);

		if (count($decValue) === 1) {
			$prefix = NULL;
			$localName = $decValue[0];
		} else {
			$prefix = $decValue[0];
			$localName = $decValue[1];
		}
		$namespaceURI = $element->lookupNamespaceURI($prefix);
		if ($namespaceURI === NULL) {
			throw new \Exception('Invalid QName "' . $value . '": Unable to look up namespace prefix.');
		}
		return array($namespaceURI, $localName);
	}

	public static function fromAttribute(\DOMElement $element, $value) {
		list($namespaceURI, $localName) = self::decode($element, $value);

		return '{' . $namespaceURI . '}' . $localName;
	}

	public static function usedNS($value) {
		
	}

	public static function toAttribute(\SimpleSAML\OOXML\Register $register, $value) {
	}

}