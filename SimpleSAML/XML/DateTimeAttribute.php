<?php

namespace SimpleSAML\XML;

class DateTimeAttribute {

	private static $utc = NULL;


	public static function parse($value) {
		assert('is_string($value)');

		if (self::$utc === NULL) {
			self::$utc = new \DateTimeZone('UTC');
		}

		$matches = array();
		if(!preg_match('/^(\\d\\d\\d\\d-\\d\\d-\\d\\dT\\d\\d:\\d\\d:\\d\\d)(?:\\.\\d+)?Z$/D', $value, $matches)) {
			throw new \Exception('Invalid SAML2 timestamp: ' . $value);
		}

		return \DateTime::createFromFormat('Y-m-d\\TH:i:s', $matches[1], self::$utc);
	}

	public static function format($value) {

		if (self::$utc === NULL) {
			self::$utc = new \DateTimeZone('UTC');
		}

		if ($value instanceof \DateTime) {
			$dti = new \DateTime('now', self::$utc);
			$dti->setTimestamp($value->getTimestamp());
		} else {
			throw new \Exception('Invalid datatype for time stamp.');
		}
		return $dti->format('Y-m-d\\TH:i:s\\Z');
	}

}