<?php

namespace SimpleSAML\XML\md;

class ExtensionsType extends \SimpleSAML\XML\ElementHelper {

	public static $_properties = array(
		'children' => array(
			'type' => 'element_list',
			'allChildren' => TRUE,
			'elementContext' => 'md_extensions',
			'allowUnknown' => TRUE,
		),
	);

}
