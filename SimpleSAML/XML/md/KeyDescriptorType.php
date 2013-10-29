<?php

namespace SimpleSAML\XML\md;

abstract class KeyDescriptorType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'KeyInfo' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\ds\NS::URI,
			'localName' => 'KeyInfo',
		),
		'EncryptionMethod' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'EncryptionMethod',
		),


		'use' => array(
			'type' => 'attribute',
			'localName' => 'use',
			'required' => FALSE,
			'attributeType' => '\\SimpleSAML\\XML\\md\\KeyTypes',
		),
	);

}
