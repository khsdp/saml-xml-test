<?php

namespace SimpleSAML\XML\md;

abstract class SPSSODescriptorType extends SSODescriptorType {
	public static $_properties = array(
		'AssertionConsumerService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AssertionConsumerService',
			'required' => TRUE,
		),
		'AttributeConsumingService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AttributeConsumingService',
		),

		'AuthnRequestsSigned' => array(
			'type' => 'attribute',
			'localName' => 'AuthnRequestsSigned',
			'attributeType' => '\\SimpleSAML\XML\xs\BooleanType',
		),
		'WantAssertionsSigned' => array(
			'type' => 'attribute',
			'localName' => 'WantAssertionsSigned',
			'attributeType' => '\\SimpleSAML\XML\xs\BooleanType',
		),

	);

}
