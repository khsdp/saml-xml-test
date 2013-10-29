<?php

namespace SimpleSAML\XML\xs;

class DurationType {

	public static function parse($value) {
		assert('is_string($value)');

		$value = trim($value);

		/* Parse the duration. We use a very strict pattern. */
		$durationRegEx = '#^(-?)P(?:(\\d+)Y)?(?:(\\d+)M)?(?:(\\d+)D)?(?:T(?:(\\d+)H)?(?:(\\d+)M)?(?:(\\d+)(?:\\.\\d+)?S)?)?$#D';
		if (!preg_match($durationRegEx, $value, $matches)) {
			throw new \Exception('Invalid xs:duration: ' . $value);
		}

		$di = new \DateInterval('PT0S');
		$di->y = (empty($matches[2]) ? 0 : (int)$matches[2]);
		$di->m = (empty($matches[3]) ? 0 : (int)$matches[3]);
		$di->d = (empty($matches[4]) ? 0 : (int)$matches[4]);
		$di->h = (empty($matches[5]) ? 0 : (int)$matches[5]);
		$di->i = (empty($matches[6]) ? 0 : (int)$matches[6]);
		$di->s = (empty($matches[7]) ? 0 : (int)$matches[7]);

		if (!empty($matches[1])) {
			/* Negative */
			$di->invert = 1;
		}

		return $di;
	}

	public static function format($value) {

		if (!($value instanceof \DateInterval)) {
			throw new \Exception('Invalid datatype for xs:duration.');
		}

		if ($value->y == 0 && $value->m == 0 && $value->d == 0 && $value->h == 0 && $value->i == 0 && $value->s == 0) {
			/* A zero-interval. We must still output at least one component. */
			return 'PT0S';
		}

		if ($value->invert) {
			/* A negative interval. */
			$out = '-P';
		} else {
			$out = 'P';
		}

		if ($value->y) {
			$out .= $value->y . 'Y';
		}
		if ($value->m) {
			$out .= $value->m . 'M';
		}
		if ($value->d) {
			$out .= $value->d . 'D';
		}

		if ($value->h || $value->i || $value->s) {
			$out .= 'T';
			if ($value->h) {
				$out .= $value->h . 'H';
			}
			if ($value->i) {
				$out .= $value->i . 'M';
			}
			if ($value->s) {
				$out .= $value->s . 'S';
			}
		}

		return $out;
	}

}