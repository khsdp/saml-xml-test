<?php

namespace SimpleSAML\XML;

class Parser {

	public static function resolveElement(\DOMElement $element) {
		$elementClass = \SimpleSAML\XML\Register::resolveElement($element->namespaceURI, $element->localName);
		if ($elementClass === NULL) {
			throw new \Exception('Unknown element: {' . $element->namespaceURI . '}' . $element->localName);
		}

		if (!$element->hasAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'type')) {
			return $elementClass;
		}

		$type = $element->getAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'type');
		$type = explode(':', $type, 2);
		if (count($type) === 2) {
			$prefix = $type[0];
			$localName = $type[1];
		} else {
			$prefix = NULL;
			$localName = $type[0];
		}
		$namespaceURI = $element->lookupNamespaceURI($prefix);

		$resolver = array($elementClass, 'resolveElement');
		if (!is_callable($resolver)) {
			throw new \Exception('xsi:type override unsupported for element {' . $element->namespaceURI . '}' . $element->localName . '.');
		}

		$implClass = call_user_func($resolver, $namespaceURI, $localName);
		if ($implClass === NULL) {
			throw new \Exception('Element {' . $element->namespaceURI . '}' . $element->localName . ' can not be overridden by {' . $namespaceURI . '}' . $localName . '.');
		}

		return $implClass;
	}

	public static function parseXML(\DOMElement $element, $elementContext = NULL, $allowUnknown = FALSE) {
		if ($elementContext === NULL) {
			$elementContext = 'element';
		}
		$elementClass = \SimpleSAML\XML\Register::resolveInContext($elementContext, $element->namespaceURI, $element->localName);
		if ($elementClass === NULL) {
			if ($allowUnknown) {
				return \SimpleSAML\XML\SimpleElement::parse($element);
			} else {
				throw new \Exception('Unknown element: {' . $element->namespaceURI . '}' . $element->localName);
			}
		}

		$parseFunc = array($elementClass, 'parse');
		if (is_callable($parseFunc)) {
			return call_user_func($parseFunc, $element);
		} else {
			return new $elementClass($element);
		}
	}

}
