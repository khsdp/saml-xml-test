<?php

namespace SimpleSAML\XML\ds;

abstract class KeyInfoType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'KeyName' => array(
			'type' => 'element_content_list',
			'namespaceURI' => NS::URI,
			'localName' => 'KeyName',
		),
		/* TODO
		'KeyValue' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'KeyValue',
		),
		*/
		/* TODO
		'RetrivalMethod' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'RetrivalMethod',
		),
		*/
		/* TODO
		'X509Data' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'X509Data',
		),
		*/
		/* TODO
		'PGPData' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'PGPData',
		),
		*/
		/* TODO
		'SPKIData' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'SPKIData',
		),
		*/
		/* TODO
		'MgmtData' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'MgmtData',
		),
		*/
		/* TODO
		'Other' => array(
			'type' => 'element_list', // TODO: need type for "other" elements.
		),
		*/

		'Id' => array(
			'type' => 'attribute',
			'localName' => 'ID',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\IDType',
			'required' => FALSE,
		),

	);

}
