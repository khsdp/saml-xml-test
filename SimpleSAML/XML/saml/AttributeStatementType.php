<?php

namespace SimpleSAML\XML\saml;

abstract class AttributeStatementType extends \SimpleSAML\XML\saml\StatementAbstractType {
	public static $_properties = array(
		'Attribute' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Attribute',
		),
		'EncryptedAttribute' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'EncryptedAttribute',
		),
	);

}
