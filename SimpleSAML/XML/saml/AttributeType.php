<?php

namespace SimpleSAML\XML\saml;

abstract class AttributeType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'AttributeValue' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'AttributeValue',
		),
		'Name' => array(
			'type' => 'attribute',
			'localName' => 'Name',
			'required' => TRUE,
		),
		'NameFormat' => array(
			'type' => 'attribute',
			'localName' => 'NameFormat',
		),
		'FriendlyName' => array(
			'type' => 'attribute',
			'localName' => 'FriendlyName',
		),
	);

	public static $_anyAttribute = TRUE;

}
