<?php

namespace SimpleSAML\XML\xs;

class IDType {

	public static function parse($value) {
		assert('is_string($value)');
		$value = trim($value);
		return $value;
	}

	public static function format($value) {
		assert('is_string($value)');
		return $value;
	}

}
