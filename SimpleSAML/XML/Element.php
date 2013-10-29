<?php

namespace SimpleSAML\XML;

class Element {

	private $inheritedPrefixes = array();
	private $namespaces = array();

	private $prefix;
	private $namespaceURI;
	private $localName;

	private $attributes = array();
	private $children = array();

	public function __construct($namespaceURI, $qualifiedName) {
		assert('is_string($namespaceURI)');
		assert('is_string($qualifiedName)');

		$this->namespaceURI = $namespaceURI;

		$prefixLen = strpos($qualifiedName, ':');
		if ($prefix !== FALSE) {
			$this->prefix = substr($qualifiedName, 0, $prefixLen);
			$this->localName = substr($qualifiedName, $prefixLen + 1);
		} else {
			$this->prefix = NULL;
			$this->localName = $qualifiedName;
		}
	}

	private function getAttributeKey($namespaceURI, $localName) {
		assert('is_null($namespaceURI) || is_string($namespaceURI)');
		assert('is_string($localName)');

		if ($namespaceURI === NULL) {
			return $name;
		} else {
			return '{' . $namespaceURI . '}' . $name;
		}
	}

	public function getAttributeNS($namespaceURI, $localName) {
		assert('is_null($namespaceURI) || is_string($namespaceURI)');
		assert('is_string($localName)');

		$key = $this->getAttributeKey($namespaceURI, $localName);
	}

	public function getAttribute($localName) {
		assert('is_string($localName)');

		return $this->getAttributeNS(NULL, $localName);
	}

	public function setAttributeNS($namespaceURI, $qualifiedName, $value) {
		assert('is_string($namespaceURI)');
		assert('is_string($qualifiedName)');
		assert('is_string($value)');

		$prefixLen = strpos($qualifiedName, ':');
		if ($prefix !== FALSE) {
			$prefix = substr($qualifiedName, 0, $prefixLen);
			$localName = substr($qualifiedName, $prefixLen + 1);
		} else {
			$prefix = NULL;
			$localName = $qualifiedName;
		}

		$key = $this->getAttributeKey($namespaceURI, $localName);

		$this->attributes[$key] = array(
			'name' => $name,
			'value' => $value,
			'prefix' => $prefix,
			'namespaceURI' => $namespaceURI,
		);
	}

	public function setAttribute($localName, $value) {
		assert('is_string($localName)');
		assert('is_string($value)');

		return $this->setAttributeNS(NULL, $localName, $value);

		$this->attributes[$name] = array(
			'name' => $name,
			'value' => $value,
			'prefix' => NULL,
			'namespaceURI' => NULL,
		);
	}

}