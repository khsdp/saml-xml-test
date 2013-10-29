<?php

namespace SimpleSAML\XML\md;

abstract class ContactType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Extensions' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Extensions',
		),
		'Company' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'Company',
		),
		'GivenName' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'GivenName',
		),
		'SurName' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'SurName',
		),
		'EmailAddress' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'EmailAddress',
			'contentType' => '\\SimpleSAML\\XML\\xs\\AnyURIType',
		),
		'TelephoneNumber' => array(
			'type' => 'element_content',
			'namespaceURI' => NS::URI,
			'localName' => 'TelephoneNumber',
		),

		'contactType' => array(
			'type' => 'attribute',
			'localName' => 'contactType',
			'attributeType' => '\\SimpleSAML\\XML\\md\\ContactTypeType',
			'required' => TRUE,
		),
	);

	public static $_anyAttribute = TRUE;

}
