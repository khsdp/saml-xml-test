<?php

namespace SimpleSAML\XML\saml;

abstract class NameIDType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'NameQualifier' => array(
			'type' => 'attribute',
			'localName' => 'NameQualifier',
		),
		'SPNameQualifier' => array(
			'type' => 'attribute',
			'localName' => 'SPNameQualifier',
		),
		'Format' => array(
			'type' => 'attribute',
			'localName' => 'Format',
		),
		'SPProvidedID' => array(
			'type' => 'attribute',
			'localName' => 'SPProvidedID',
		),
		'Value' => array(
			'type' => 'text_content',
		),
	);
}
