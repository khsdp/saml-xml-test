<?php

namespace SimpleSAML\XML;

class Utils {

	public static function findNSPrefix(\DOMNode $target = NULL, $namespaceURI) {
		assert('is_string($namespaceURI)');

		/* First, see if it is already defined for the element. */
		$prefix = $target->lookupPrefix($namespaceURI);
		if ($prefix) {
			return $prefix;
		}

		/* Try the default prefix (if any). */
		$prefix = \SimpleSAML\XML\Register::getPrefix($namespaceURI);
		if ($prefix !== NULL) {
			if ($target->lookupNamespaceURI($prefix) === NULL) {
				/* This doesn't exist from before. Use it. */
				return $prefix;
			}
		}

		/* Create a prefix. */
		for ($i = 0; ; $i++) {
			$prefix = 'ns' . $i;
			if ($target->lookupNamespaceURI($prefix) === NULL) {
				return $prefix;
			}
		}
	}

}
