<?php

namespace SimpleSAML\XML\md;

abstract class RoleDescriptorType extends \SimpleSAML\XML\ElementHelper {
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
		'KeyDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'KeyDescriptor',
		),
		'Organization' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Organization',
		),
		'ContactPerson' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ContactPerson',
		),


		'ID' => array(
			'type' => 'attribute',
			'localName' => 'ID',
			'required' => FALSE,
		),
		'validUntil' => array(
			'type' => 'attribute',
			'localName' => 'validUntil',
			'decoder' => '\\SimpleSAML\\XML\\saml\UTCDateTimeType',
			'required' => FALSE,
		),
		'cacheDuration' => array(
			'type' => 'attribute',
			'localName' => 'cacheDuration',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\DurationType',
			'required' => FALSE,
		),
		'protocolSupportEnumeration' => array(
			'type' => 'attribute',
			'localName' => 'protocolSupportEnumeration',
			'required' => TRUE,
		),
	);

}
