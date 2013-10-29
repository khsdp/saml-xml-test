<?php

namespace SimpleSAML\XML\saml;

class StringAttributeValue extends BaseAttributeValue {

	private $text = '';

	public function __construct($text) {
		assert('is_string($text)');
		$this->text = $text;
	}

	public function getText() {
		return $this->text;
	}

	public function toXML($parent) {
		if ($parent instanceof \DOMDocument) {
			$doc = $parent;
		} else {
			$doc = $parent->ownerDocument;
		}

		$element = $doc->createElementNS(NS::URI, NS::PREFIX . ':AttributeValue');
		$parent->appendChild($parent);

		$element->setAttributeNS('http://www.w3.org/2001/XMLSchema', 'xs:__ns_workaround__', 'tmp');
		$element->removeAttributeNS('http://www.w3.org/2001/XMLSchema', '__ns_workaround__');
		$element->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:type', 'xs:string');

		$element->appendChild($doc->createTextNode($this->text));

		return $element;
	}

}
