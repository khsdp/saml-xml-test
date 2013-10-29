<?php

namespace SimpleSAML\XML\md;

abstract class SSODescriptorType extends RoleDescriptorType {
	public static $_properties = array(
		'ArtifactResolutionService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ArtifactResolutionService',
		),
		'SingleLogoutService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'SingleLogoutService',
		),
		'ManageNameIDService' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ManageNameIDService',
		),
		'NameIDFormat' => array(
			'type' => 'element_content_list',
			'namespaceURI' => NS::URI,
			'localName' => 'NameIDFormat',
			'contentType' => '\\SimpleSAML\\XML\\xs\\AnyURIType',
		),
	);

}
