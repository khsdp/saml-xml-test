<?php

namespace SimpleSAML\XML\ds;

class NS {

	const URI = 'http://www.w3.org/2000/09/xmldsig#';
	const PREFIX = 'ds';

	public static $element = array(
		'KeyInfo' => '\\SimpleSAML\\XML\\ds\\KeyInfo',
	);

}
