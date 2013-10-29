<?php

namespace SimpleSAML\XML\md;

abstract class IndexedEndpointType extends EndpointType {
	public static $_properties = array(
		'index' => array(
			'type' => 'attribute',
			'localName' => 'index',
			'attributeType' => '\\SimpleSAML\XML\xs\UnsignedShortType',
			'required' => TRUE,
		),
		'isDefault' => array(
			'type' => 'attribute',
			'localName' => 'isDefault',
			'attributeType' => '\\SimpleSAML\XML\xs\BooleanType',
			'required' => FALSE,
		),
	);

}
