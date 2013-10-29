<?php

namespace SimpleSAML\XML\saml;

abstract class AssertionType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Issuer' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Issuer',
			'required' => TRUE,
		),
		'Signature' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\ds\Consts::NS_DS,
			'localName' => 'Signature',
		),
		'Subject' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Subject',
		),
		'Conditions' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Conditions',
		),
		'Advice' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Advice',
		),
		'Statement' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'Statement',
		),
		'AuthnStatement' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'AuthnStatement',
		),
		'AuthzDecisionStatement' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'AuthzDecisionStatement',
		),
		'AttributeStatement' => array(
			'type' => 'element_list',
			'namespaceURI' => \SimpleSAML\XML\saml\NS::URI,
			'localName' => 'AttributeStatement',
		),

		'Version' => array(
			'type' => 'attribute',
			'localName' => 'Version',
			'required' => TRUE,
		),
		'ID' => array(
			'type' => 'attribute',
			'localName' => 'ID',
			'required' => TRUE,
		),
		'IssueInstant' => array(
			'type' => 'attribute',
			'localName' => 'IssueInstant',
			'attributeType' => '\\SimpleSAML\\XML\\saml\\UTCDateTimeType',
			'required' => TRUE,
		),
	);

}
