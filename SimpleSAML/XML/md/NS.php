<?php

namespace SimpleSAML\XML\md;

class NS {

	const URI = 'urn:oasis:names:tc:SAML:2.0:metadata';
	const PREFIX = 'md';

	public static $element = array(
		'ArtifactResolutionService' => '\\SimpleSAML\\XML\\md\\ArtifactResolutionService',
		'AssertionConsumerService' => '\\SimpleSAML\\XML\\md\\AssertionConsumerService',
		'AttributeAuthorityDescriptor' => '\\SimpleSAML\\XML\\md\\AttributeAuthorityDescriptor',
		'AttributeConsumingService' => '\\SimpleSAML\\XML\\md\\AttributeConsumingService',
		'AttributeService' => '\\SimpleSAML\\XML\\md\\AttributeService',
		'ContactPerson' => '\\SimpleSAML\\XML\\md\\ContactPerson',
		'KeyDescriptor' => '\\SimpleSAML\\XML\\md\\KeyDescriptor',
		'EntityDescriptor' => '\\SimpleSAML\\XML\\md\\EntityDescriptor',
		'Extensions' => '\\SimpleSAML\\XML\\md\\Extensions',
		'IDPSSODescriptor' => '\\SimpleSAML\\XML\\md\\IDPSSODescriptor',
		'NameIDFormat' => '\\SimpleSAML\\XML\\md\\NameIDFormat',
		'ManageNameIDService' => '\\SimpleSAML\\XML\\md\\ManageNameIDService',
		'Organization' => '\\SimpleSAML\\XML\\md\\Organization',
		'RequestedAttribute' => '\\SimpleSAML\\XML\\md\\RequestedAttribute',
		'RoleDescriptor' => '\\SimpleSAML\\XML\\md\\RoleDescriptor',
		'SingleLogoutService' => '\\SimpleSAML\\XML\\md\\SingleLogoutService',
		'SingleSignOnService' => '\\SimpleSAML\\XML\\md\\SingleSignOnService',
		'SPSSODescriptor' => '\\SimpleSAML\\XML\\md\\SPSSODescriptor',
	);

}
