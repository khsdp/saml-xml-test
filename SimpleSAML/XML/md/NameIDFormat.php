<?php

namespace SimpleSAML\XML\md;

class NameIDFormat extends \SimpleSAML\XML\ElementHelper {
	public static $_localName = 'NameIDFormat';
	public static $_namespaceURI = NS::URI;

	public static $_properties = array(
		'uri' => array(
			'type' => 'text_content',
			'required' => TRUE,
			'contentType' => '\\SimpleSAML\\XML\\xs\\AnyURIType',
		),
	);

}
