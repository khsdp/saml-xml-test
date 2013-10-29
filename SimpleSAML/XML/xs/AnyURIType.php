<?php

namespace SimpleSAML\XML\xs;

class AnyURIType {

	public static function parse($value) {
		assert('is_string($value)');
		$value = trim($value);
		if (empty($value)) {
			throw new \Exception('Empty value for xs:anyURI.');
		}
		return $value;
	}

	public static function format($value) {
		assert('is_string($value)');
		return $value;
	}

}
