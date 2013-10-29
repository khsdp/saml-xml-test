<?php

namespace SimpleSAML\XML\saml;

abstract class BaseAttributeValue {
	public static $_localName = 'AttributeValue';
	public static $_namespaceURI = \SimpleSAML\XML\saml\NS::URI;

	public static function resolveElement($namespaceURI, $localName) {
		if ($namespaceURI === 'http://www.w3.org/2001/XMLSchema-instance' && $localName === 'string') {
			return '\\SimpleSAML\\XML\\saml\\StringAttributeValue';
		}

		$cls = \SimpleSAML\XML\Register::resolveInContext('saml_attributevalue', $namespaceURI, $localName);
		if ($cls !== NULL) {
			return $cls;
		}
		return '\\SimpleSAML\\XML\\saml\\AttributeValue';
	}

	abstract public function getText();
	abstract public function toXML($parent);
	abstract public function getChildren();

}
