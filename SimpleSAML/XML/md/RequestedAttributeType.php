<?php

namespace SimpleSAML\XML\md;

abstract class RequestedAttributeType extends \SimpleSAML\XML\saml\Attribute {
	public static $_properties = array(
		'isDefault' => array(
			'type' => 'attribute',
			'localName' => 'isRequired',
			'attributeType' => '\\SimpleSAML\XML\xs\BooleanType',
			'required' => FALSE,
		),
	);

}
