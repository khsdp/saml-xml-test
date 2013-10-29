<?php

namespace SimpleSAML\XML\saml;

class AttributeValue extends \SimpleSAML\XML\SimpleElement {

	public function __construct() {
		parent::__construct(NS::URI, 'AttributeValue');
	}

	public static function parse(\DOMElement $element) {
		$e = new AttributeValue();
		$e->extractFrom($element);
		return $e;
	}

}
