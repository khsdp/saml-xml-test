<?php

namespace SimpleSAML\OOXML;

class Parser {

	protected $register;

	public function __construct($register = NULL) {
		if ($register === NULL) {
			$register = Register::getDefault();
		}
		$this->register = $register;
	}

	protected function findClass($namespaceURI, $localName) {
		$regCls = $this->register->resolveNamespace($namespaceURI);
		if (!$regCls) {
			return NULL;
		}
		if (!isset($regCls::$elements[$localName])) {
			return NULL;
		}
		return $regCls::$elements[$localName];
	}

	protected function extractAttributes(\DOMElement $element, $elementClass) {
		$attributes = array();
		foreach ($element->attributes as $attr) {
			$namespaceURI = $attr->namespaceURI;
			$localName = $attr->localName;
			$value = $attr->value;

			if ($namespaceURI) {
				$nsName = '{' . $namespaceURI . '}' . $localName;
			} else {
				$nsName = $localName;
			}

			if (isset($elementClass::$prefixAttributes) && isset($elementClass::$prefixAttributes[$nsName])) {
				$callable = array($elementClass::$prefixAttributes[$nsName], 'fromAttribute');
				$value = call_user_func($callable, $element, $value);
			} else {
				if ($namespaceURI) {
					$ns = $this->register->resolveNamespace($namespaceURI);
					if ($ns && isset($ns::$prefixAttributes[$localName])) {
						$callable = array($ns::$prefixAttributes[$localName], 'fromAttribute');
						$value = call_user_func($callable, $element, $value);
					}
				}
			}

			$attributes[$nsName] = $value;
		}
		return $attributes;
	}

	protected function extractChildren(\DOMElement $element) {
		$children = array();
		foreach ($element->childNodes as $child) {
			if ($child instanceof \DOMText) {
				$children[] = $child->data;
				continue;
			} elseif ($child instanceof \DOMElement) {
				$children[] = $this->parse($child);
				continue;
			} elseif ($child instanceof \DOMComment) {
				/* Ignore comment. */
			} else {
				throw new Exception('Don\'n know how to parse XML of type ' . get_class($child) . '.');
			}
		}
		return $children;
	}

	public function parse(\DOMElement $element) {
		if ($element->hasAttributeNS(\SimpleSAML\OOXML\xsi\NS::URI, 'type')) {
			$type = $element->getAttributeNS(\SimpleSAML\OOXML\xsi\NS::URI, 'type');
			list($namespaceURI, $localName) = \SimpleSAML\OOXML\UnPrefix\QName::decode($element, $type);
		} else {
			$namespaceURI = $element->namespaceURI;
			$localName = $element->localName;
		}

		$cls = $this->findClass($namespaceURI, $localName);
		if ($cls === NULL) {
			$cls = '\\SimpleSAML\\OOXML\\Element';
		}
		$inst = new $cls();
		$attributes = $this->extractAttributes($element, $cls);
		$children = $this->extractChildren($element);
		$inst->fromParsed($element->namespaceURI, $element->localName, $attributes, $children);

		return $inst;
	}

}
