<?php

namespace SimpleSAML\XML\md;

abstract class OrganizationType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Extensions' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Extensions',
		),
		'OrganizationName' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'OrganizationName',
		),
		'OrganizationDisplayName' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'OrganizationDisplayName',
		),
		'OrganizationURL' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'OrganizationURL',
		),
	);

	public static $_anyAttribute = TRUE;

}
