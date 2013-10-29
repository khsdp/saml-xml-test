<?php

namespace SimpleSAML\XML\md;

class ContactTypeType {

	public static $types = array(
		'technical',
		'support',
		'administrative',
		'billing',
		'other',
	);


	public static function parse($value) {
		assert('is_string($value)');

		if (!in_array($value, self::$types, TRUE)) {
			throw new \Exception('Invalid value for contactType attribute.');
		}
		return $value;
	}

	public static function format($value) {
		assert('is_string($value)');
		assert('in_array($value, self::$types, TRUE)');
		return $value;
	}

}
