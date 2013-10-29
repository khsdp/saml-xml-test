<?php

namespace SimpleSAML\XML\md;

abstract class AttributeAuthorityDescriptorType extends RoleDescriptorType {
	public static $_properties = array(
		'AttributeService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AttributeService',
			'required' => TRUE,
		),
		'AssertionIDRequestService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AssertionIDRequestService',
		),
		'NameIDFormat' => array(
			'type' => 'element_content_list',
			'namespaceURI' => NS::URI,
			'localName' => 'NameIDFormat',
			'contentType' => '\\SimpleSAML\\XML\\xs\\AnyURIType',
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
	);

}
