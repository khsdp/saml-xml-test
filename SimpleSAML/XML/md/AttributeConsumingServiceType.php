<?php

namespace SimpleSAML\XML\md;

abstract class AttributeConsumingServiceType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'ServiceName' => array(
			'type' => 'element_content_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ServiceName',
		),
		'ServiceDescription' => array(
			'type' => 'element_content_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ServiceDescription',
		),
		'RequestedAttribute' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'RequestedAttribute',
		),

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
