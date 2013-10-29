<?php

namespace SimpleSAML\OOXML;

class AltSerializationContext {

	protected $register;

	public $namespaces = array();

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

}
