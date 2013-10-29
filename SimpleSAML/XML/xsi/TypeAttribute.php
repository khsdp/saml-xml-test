<?php

namespace SimpleSAML\XML\xsi;

class TypeAttribute {

	public static function read(\DOMElement $element) {
		if (!$element->hasAttributeNS(NS::URI, 'type')) {
			return NULL;
		}
		$value = $element->getAttributeNS(NS::URI, 'type');
		$value = explode(':', $value, 2);
		if (count($value) === 1) {
			$prefix = NULL;
			$localName = $value[0];
		} else {
			$prefix = $value[0];
			$localName = $value[1];
		}
		$namespaceURI = $element->lookupNamespaceURI($prefix);
		if ($namespaceURI === NULL) {
			throw new \Exception('Malformed xsi:type. Unable to find prefix "' . $prefix . '".');
		}
		return array($namespaceURI, $localName);
	}

	public static function write(\DOMElement $element, array $type = NULL) {
		if ($type === NULL) {
			return;
		}
		assert('count($type) === 2');
		$namespaceURI = $type[0];
		$localName = $type[1];

		$prefix = \SimpleSAML\XML\Utils::findNSPrefix($element, $namespaceURI);
		$element->setAttributeNS($namespaceURI, $prefix . ':__ns_workaround__', 'tmp');
		$element->removeAttributeNS($namespaceURI, '__ns_workaround__');
		$element->setAttributeNS(NS::URI, 'xsi:type', $prefix . ':' . $localName);
	}

}
