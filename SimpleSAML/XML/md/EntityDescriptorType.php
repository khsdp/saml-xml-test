<?php

namespace SimpleSAML\XML\md;

abstract class EntityDescriptorType extends \SimpleSAML\XML\ElementHelper {
	public static $_properties = array(
		'Signature' => array(
			'type' => 'element',
			'namespaceURI' => \SimpleSAML\XML\ds\Consts::NS_DS,
			'localName' => 'Signature',
		),
		'Extensions' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Extensions',
		),
		'RoleDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'RoleDescriptor',
		),
		'IDPSSODescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'IDPSSODescriptor',
		),
		'SPSSODescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'SPSSODescriptor',
		),
		'AuthnAuthorityDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AuthnAuthorityDescriptor',
		),
		'AttributeAuthorityDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AttributeAuthorityDescriptor',
		),
		'PDPDescriptor' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'PDPDescriptor',
		),
		'AffiliationDescriptor' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'AffiliationDescriptor',
		),
		'Organization' => array(
			'type' => 'element',
			'namespaceURI' => NS::URI,
			'localName' => 'Organization',
		),
		'ContactPerson' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'ContactPerson',
		),
		'AdditionalMetadataLocation' => array(
			'type' => 'element_list',
			'namespaceURI' => NS::URI,
			'localName' => 'AdditionalMetadataLocation',
		),


		'entityID' => array(
			'type' => 'attribute',
			'localName' => 'entityID',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\AnyURIType',
			'required' => TRUE,
		),
		'validUntil' => array(
			'type' => 'attribute',
			'localName' => 'validUntil',
			'attributeType' => '\\SimpleSAML\\XML\\saml\UTCDateTimeType',
			'required' => FALSE,
		),
		'cacheDuration' => array(
			'type' => 'attribute',
			'localName' => 'cacheDuration',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\DurationType',
			'required' => FALSE,
		),
		'ID' => array(
			'type' => 'attribute',
			'localName' => 'ID',
			'attributeType' => '\\SimpleSAML\\XML\\xs\\IDType',
			'required' => FALSE,
		),
	);

	public static $_anyAttribute = TRUE;

}
