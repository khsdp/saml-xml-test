<?php

namespace SimpleSAML\XML\md;

abstract class EntitiesDescriptorType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Signature' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\ds\Consts::NS_DS,
			'localName' => 'Signature',
		),
		'Extensions' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Extensions',
		),
		'EntityDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'EntityDescriptor',
		),
		'EntitiesDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'EntitiesDescriptor',
		),


		'validUntil' => array(
			'type' => 'attribute',
			'localName' => 'validUntil',
			'attributeType' => '\\SimpleSAML\\XML\\saml\UTCDateTimeType',
			'required' => FALSE,
		),
		'cacheDuration' => array(
			'type' => 'attribute',
			'localName' => 'cacheDuration',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\DurationType',
			'required' => FALSE,
		),
		'ID' => array(
			'type' => 'attribute',
			'localName' => 'ID',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\IDType',
			'required' => FALSE,
		),
		'Name' => array(
			'type' => 'attribute',
			'localName' => 'Name',
			'required' => FALSE,
		),
	);

}
