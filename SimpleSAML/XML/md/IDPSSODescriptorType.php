<?php

namespace SimpleSAML\XML\md;

abstract class IDPSSODescriptorType extends SSODescriptorType {
	public static $_properties = array(
		'SingleSignOnService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'SingleSignOnService',
		),
		'NameIDMappingService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'NameIDMappingService',
		),
		'AssertionIDRequestService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AssertionIDRequestService',
		),
		'AttributeProfile' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AttributeProfile',
		),
		'Attribute' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Attribute',
		),

		'WantAuthnRequestsSigned' => array(
			'type' => 'attribute',
			'localName' => 'WantAuthnRequestsSigned',
		),

	);

}
