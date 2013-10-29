<?php

namespace SimpleSAML\OOXML;

class Element {

	public $namespaceURI;
	public $localName;

	public $attributes = array();
	public $children = array();

	public function __construct($namespaceURI = NULL, $localName = NULL) {
		$this->namespaceURI = $namespaceURI;
		$this->localName = $localName;
	}

	public function fromParsed($namespaceURI, $localName, array $attributes, array $children) {
		$this->namespaceURI = $namespaceURI;
		$this->localName = $localName;
		$this->attributes = $attributes;
		$this->children = $children;
	}

	protected function addAttributes(\DOMElement $element) {
		foreach ($this->attributes as $name => $value) {
			if ($name[0] !== '{') {
				/* Not namespace prefixed attribute. */
				$element->setAttribute($name, $value);
				continue;
			}

			$nsEndPos = strpos($name, '}', 1);
			assert('$nsEndPos !== FALSE');
			$namespaceURI = substr($name, 1, $nsEndPos - 1);
			$localName = substr($name, $nsEndPos + 1);

			$attrParser = \SimpleSAML\XML\Register::resolveAttribute($namespaceURI, $localName);
			if ($attrParser) {
				$formatFunc = array($attrParser, 'format');
				if ($attrParser && is_callable($formatFunc)) {
					$value = call_user_func($formatFunc, $value);
				}


				$writeFunc = array($attrParser, 'write');
				if ($attrParser && is_callable($writeFunc)) {
					/* We have a custom write function. */
					call_user_func($writeFunc, $element, $value);
					continue;
				}
			}

			/* We need to write the attribute ourselves. */
			$prefix = \SimpleSAML\XML\Utils::findNSPrefix($element, $namespaceURI);
			$element->setAttributeNS($namespaceURI, $prefix . ':' . $localName, $value);
		}
	}

	protected function addChildren(\DOMElement $element) {
		foreach ($this->children as $child) {
			if (is_string($child)) {
				$textNode = $element->ownerDocument->createTextNode($child);
				$element->appendChild($textNode);
			} else {
				$child->toXML($element);
			}
		}
	}

	protected function extractFrom(\DOMElement $element) {
		$this->extractAttributes($element);
		$this->extractChildren($element);
	}

	public static function parse(\DOMElement $element) {
		$e = new SimpleElement($element->namespaceURI, $element->localName);
		$e->extractFrom($element);
		return $e;
	}

	public function toXML($parent) {

		if ($parent instanceof \DOMDocument) {
			$doc = $parent;
		} else {
			$doc = $parent->ownerDocument;
		}

		$prefix = \SimpleSAML\XML\Utils::findNSPrefix($parent, $this->namespaceURI);
		$element = $doc->createElementNS($this->namespaceURI, $prefix . ':' . $this->localName);
		$parent->appendChild($element);

		$this->addAttributes($element);
		$this->addChildren($element);

		return $element;
	}

}
