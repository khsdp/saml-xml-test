<?php

namespace SimpleSAML\OOXML;

class SerializationContext {

	protected $register;

	protected $namespaces = array();

	protected $document;

	public function __construct($register = NULL) {
		if ($register === NULL) {
			$register = Register::getDefault();
		}
		$this->register = $register;
		$this->document = new \DOMDocument();
	}

	public function qName($namespaceURI, $localName) {
		if (!isset($this->namespaces[$namespaceURI])) {
			$prefix = $this->register->getPrefix($namespaceURI);
			$this->namespaces[$namespaceURI] = $prefix;
		}
		return $this->namespaces[$namespaceURI] . ':' . $localName;
	}

	public function createElement($namespaceURI, $localName) {
		$qName = $this->qName($namespaceURI, $localName);
		$element = $this->document->createElementNS($namespaceURI, $qName);
		return $element;
	}

	public function addText(\DOMElement $parent, $text) {
		$te = $this->document->createTextNode($text);
		$parent->appendChild($te);
	}

	public function finish(\DOMElement $root) {
		foreach ($this->namespaces as $namespaceURI => $prefix) {
			/* Add namespace declaration to the root. */
			$root->setAttributeNS($namespaceURI, $prefix . ':__init_ns__', 'tmp');
			$root->removeAttributeNS($namespaceURI, '__init_ns__');
		}
		$this->document->appendChild($root);
		$xml = $this->document->saveXML($root);
		return $xml;
	}

}
