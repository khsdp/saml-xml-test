<?php

namespace SimpleSAML\XML\saml;

class NS {

	const URI = 'urn:oasis:names:tc:SAML:2.0:assertion';
	const PREFIX = 'saml';

	public static $element = array(
		'Assertion' => '\\SimpleSAML\\XML\\saml\\Assertion',
		'Attribute' => '\\SimpleSAML\\XML\\saml\\Attribute',
		'AttributeValue' => '\\SimpleSAML\\XML\\saml\\AttributeValue',
		'AttributeStatement' => '\\SimpleSAML\\XML\\saml\\AttributeStatement',
		'Issuer' => '\\SimpleSAML\\XML\\saml\\Issuer',
	);

}
