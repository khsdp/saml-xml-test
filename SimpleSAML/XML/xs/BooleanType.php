<?php

namespace SimpleSAML\XML\xs;

class BooleanType {

	public static function parse($value) {
		assert('is_string($value)');

		if ($value === 'false' || $value === '0') {
			return FALSE;
		} elseif ($value === 'true' || $value === '1') {
			return TRUE;
		}
		throw new \Exception('Invalid value for xs:boolean.');
	}

	public static function format($value) {
		assert('is_bool($value)');
		if ($value) {
			return 'true';
		} else {
			return 'false';
		}
	}

}
