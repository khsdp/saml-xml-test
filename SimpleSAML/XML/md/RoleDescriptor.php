<?php

namespace SimpleSAML\XML\md;

class RoleDescriptor extends RoleDescriptorType {
	public static $_localName = 'RoleDescriptor';
	public static $_namespaceURI = NS::URI;

	public static function parse(\DOMElement $element) {
		$type = \SimpleSAML\XML\xsi\TypeAttribute::read($element);
		if ($type === NULL) {
			throw new Exception('Missing xsi:type on RoleDescriptor.');
		}
		$namespaceURI = $type[0];
		$localName = $type[1];

		$cls = \SimpleSAML\XML\Register::resolveInContext('md_RoleDescriptor', $namespaceURI, $localName);
		if (!$cls) {
			/* Unknown type. */
			return \SimpleSAML\XML\SimpleElement::parse($element);
		}

		$parseFunc = array($cls, 'parse');
		if (is_callable($parseFunc)) {
			/* Custom parser. */
			return call_user_func($parseFunc, $element);
		}

		/* Parse through constructor. */
		return new $cls($element);
	}

}
