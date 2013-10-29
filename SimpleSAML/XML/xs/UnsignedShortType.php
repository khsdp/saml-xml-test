<?php

namespace SimpleSAML\XML\xs;

class UnsignedShortType {

	public static function parse($value) {
		assert('is_string($value)');

		$value = trim($value);
		if (!ctype_digit($value)) {
			throw new \Exception('Invalid value for xs:unsignedShort.');
		}
		$value = (int)$value;
		if ($value < 0 || $value > 65535) {
			throw new \Exception('Value for xs:unsignedShort out of range.');
		}
		return $value;
	}

	public static function format($value) {
		assert('is_int($value)');
		assert('$value >= 0 && $value <= 65535');
		return (string)$value;
	}

}
