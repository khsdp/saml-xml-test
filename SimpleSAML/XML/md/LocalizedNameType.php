<?php

namespace SimpleSAML\XML\md;

class LocalizedNameType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'lang' => array(
			'type' => 'attribute',
			'namespaceURI' => 'http://www.w3.org/XML/1998/namespace',
			'localName' => 'lang',
			'required' => TRUE,
		),
		'text' => array(
			'type' => 'text_content',
		),
	);

}
