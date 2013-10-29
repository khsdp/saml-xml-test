<?php

namespace SimpleSAML\OOXML;

class Register {

	public static $defaultInstance = NULL;

	public static $defaultRegister = array(
#		\SimpleSAML\OOXML\xs\NS::URI => '\SimpleSAML\OOXML\xs\NS',
		\SimpleSAML\OOXML\xsi\NS::URI => '\SimpleSAML\OOXML\xsi\NS',
	);

	protected $namespaces;

	protected $prefixes;
	protected $usedPrefixes;

	public function __construct() {
		$this->namespaces = array();
		$this->prefixes = array(
			'http://www.w3.org/XML/1998/namespace' => 'xml',
		);
		$this->usedPrefixes = array(
			'xml' => TRUE,
		);
	}

	public function addDefaults() {
		$this->namespaces = array_merge(self::$defaultRegister, $this->namespaces);
	}

	public function addNamespace($namespaceURI, $cls) {
		$this->namespaces[$namespaceURI] = $cls;
	}

	public function resolveNamespace($namespaceURI) {
		if (!isset($this->namespaces[$namespaceURI])) {
			return NULL;
		}
		return $this->namespaces[$namespaceURI];
	}

	public function getPrefix($namespaceURI) {
		if (isset($this->prefixes[$namespaceURI])) {
			return $this->prefixes[$namespaceURI];
		}

		if (isset($this->namespaces[$namespaceURI])) {
			$cls = $this->namespaces[$namespaceURI];
			$prefix = $cls::PREFIX;
			if (!isset($this->usedPrefixes[$prefix])) {
				$this->usedPrefixes[$prefix] = TRUE;
				$this->prefixes[$namespaceURI] = $prefix;
				return $prefix;
			}
		}

		/* We need to generate a new prefix. */
		for ($i = 0;; $i += 1) {
			$prefix = 'ns' . $i;
			if (!isset($this->usedPrefixes[$prefix])) {
				$this->usedPrefixes[$prefix] = TRUE;
				$this->prefixes[$namespaceURI] = $prefix;
				return $prefix;
			}
		}
	}

	public static function getDefault() {
		if (self::$defaultInstance === NULL) {
			self::$defaultInstance = new Register();
			self::$defaultInstance->addDefaults();
		}
		return self::$defaultInstance;
	}

}
