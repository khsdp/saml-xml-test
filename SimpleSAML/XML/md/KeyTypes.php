<?php

namespace SimpleSAML\XML\md;

class KeyTypes {

	public static function parse($value) {
		assert('is_string($value)');

		if ($value === 'signing' || $value === 'encryption') {
			return $value;
		}
		throw new \Exception('Invalid value for md:KeyTypes.');
	}

	public static function format($value) {
		assert('is_string($value)');
		assert('$value === "signing" || $value === "encryption"');
		return $value;
	}

}
