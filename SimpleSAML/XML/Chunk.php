<?php

namespace SimpleSAML\XML;

/**
 * Serializable class used to hold an XML element.
 *
 * @package simpleSAMLphp
 * @version $Id$
 */
class Chunk {

	/**
	 * The localName of the element.
	 *
	 * @var string
	 */
	public $localName;


	/**
	 * The namespaceURI of this element.
	 *
	 * @var string
	 */
	public $namespaceURI;


	/**
	 * The DOMElement we contain.
	 *
	 * @var DOMElement
	 */
	private $xml;


	/**
	 * The DOMElement as a text string. Used during serialization.
	 *
	 * @var string|NULL
	 */
	private $xmlString;


	/**
	 * Create a XMLChunk from a copy of the given DOMElement.
	 *
	 * @param DOMElement $xml  The element we should copy.
	 */
	public function __construct(\DOMElement $xml) {

		$this->localName = $xml->localName;
		$this->namespaceURI = $xml->namespaceURI;

		$namespaces = self::getParentNS($xml);

		if (isset($namespaces[''])) {
			$rootNS = $namespaces[''];
		} else {
			$rootNS = NULL;
		}

		$document = new \DOMDocument();
		$root = $document->createElementNS($rootNS, 'root');
		$document->appendChild($root);

		foreach ($namespaces as $prefix => $uri) {
			if ($prefix !== '') {
				$root->setAttributeNS($uri, $prefix . ':__ns_workaround__', 'tmp');
				$root->removeAttributeNS($uri, '__ns_workaround__');
			}
		}

		$root->appendChild($document->importNode($xml, TRUE));
		$this->xml = $root;
	}

	private static function getParentNS(\DOMElement $element) {

		$xp = new \DOMXPath($element->ownerDocument);

		$namespaces = array();
		for ($e = $element->parentNode; $e !== NULL; $e = $e->parentNode) {
			if ($e instanceof \DOMDocument) {
				break;
			}
			foreach ($xp->query('./namespace::*', $e) as $ns) {
				$prefix = $ns->localName;
				error_log( $prefix);
				if ($prefix === 'xml') {
					continue;
				} elseif ($prefix === 'xmlns') {
					$prefix = '';
				}
				$uri = $ns->nodeValue;
				if (!isset($namespaces[$prefix])) {
					$namespaces[$prefix] = $uri;
				}
			}
		}

		return $namespaces;
	}


	/**
	 * Get this DOMElement.
	 *
	 * @return DOMElement  This element.
	 */
	public function getXML() {
		assert('$this->xml instanceof DOMElement || is_string($this->xmlString)');

		if ($this->xml === NULL) {
			$doc = new \DOMDocument();
			$doc->loadXML($this->xmlString);
			$this->xml = $doc->documentElement;
		}

		return $this->xml->firstChild;
	}


	/**
	 * Append this XML element to a different XML element.
	 *
	 * @param DOMElement|DOMDocument $parent  The element we should append this element to.
	 * @return DOMElement  The new element.
	 */
	public function toXML($parent) {

		if ($parent instanceof \DOMDocument) {
			$doc = $parent;
		} else {
			$doc = $parent->ownerDocument;
		}

		$xml = $this->getXML();
		$element = $doc->importNode($xml, TRUE);
		$parent->appendChild($element);

		$namespaces = self::getParentNS($xml);
		foreach ($namespaces as $prefix => $uri) {
			if ($prefix !== '') {
				$element->setAttributeNS($uri, $prefix . ':__ns_workaround__', 'tmp');
			} else {
				/* This is an ugly hack, but it is better than nothing. */
				$element->setAttribute('xmlns', $uri);
			}
			$element->removeAttributeNS($uri, '__ns_workaround__');
		}

		return $element;
	}


	/**
	 * Serialization handler.
	 *
	 * Converts the XML data to a string that can be serialized
	 *
	 * @return array  List of properties that should be serialized.
	 */
	public function __sleep() {
		assert('$this->xml instanceof DOMElement || is_string($this->xmlString)');

		if ($this->xmlString === NULL) {
			$this->xmlString = $this->xml->ownerDocument->saveXML($this->xml);
		}

		return array('xmlString', 'localName', 'namespaceURI');
	}

}
