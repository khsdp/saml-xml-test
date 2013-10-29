<?php

namespace SimpleSAML\XML\md;

abstract class EndpointType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Binding' => array(
			'type' => 'attribute',
			'localName' => 'Binding',
			'required' => TRUE,
			'attributeType' => '\\SimpleSAML\\XML\\xs\\AnyURIType'
		),
		'Location' => array(
			'type' => 'attribute',
			'localName' => 'Location',
			'required' => TRUE,
			'attributeType' => '\\SimpleSAML\\XML\\xs\\AnyURIType'
		),
		'ResponseLocation' => array(
			'type' => 'attribute',
			'localName' => 'ResponseLocation',
			'required' => FALSE,
			'attributeType' => '\\SimpleSAML\\XML\\xs\\AnyURIType'
		),
	);

	public static $_anyAttribute = TRUE;

}
