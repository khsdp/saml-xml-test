<?php

namespace SimpleSAML\XML;

class ElementHelper {

	protected $properties;

	public function __construct(\DOMElement $element = NULL) {

		$this->initProperties();
		if ($element) {
			$this->loadElement($element);
		}
	}

	protected function getClasses() {
		$cls = get_class($this);
		$ret = array();
		while ($cls !== false) {
			array_unshift($ret, $cls);
			$cls = get_parent_class($cls);
		}
		return $ret;
	}

	protected function initProperties() {

		$this->properties = array();

		$prev = NULL;
		foreach ($this->getClasses() as $cls) {
			if (isset($cls::$_properties)) {
				if ($cls::$_properties === $prev) {
					continue;
				}
				foreach ($cls::$_properties as $name => &$def) {
					$this->properties[$name] = array(
						'definition' => &$def,
						'value' => NULL,
					);
				}
				$prev = $cls::$_properties;
			}
		}
	}

	protected static function referenceID($namespaceURI, $localName) {
		if ($namespaceURI !== NULL) {
			return '{' . $namespaceURI . '}' . $localName;
		} else {
			return $localName;
		}
	}

	protected static function findChildren(array &$definition, \DOMElement $element) {

		$allChildren = isset($definition["allChildren"]) && $definition["allChildren"];
		$ret = array();

		if ($allChildren) {
			/* Grab all child elements. */
			foreach ($element->childNodes as $node) {
				if (!($node instanceof \DOMElement)) {
					continue;
				}
				$ret[] = $node;
			}
		} else {
			/* Grap specific child elements. */
			assert('isset($definition["localName"]) && isset($definition["namespaceURI"])');
			$localName = $definition['localName'];
			$namespaceURI = $definition['namespaceURI'];

			foreach ($element->childNodes as $node) {
				if (!($node instanceof \DOMElement)) {
					continue;
				}
				if ($node->namespaceURI === $namespaceURI && $node->localName == $localName) {
					$ret[] = $node;
				}
			}
		}

		if (empty($ret) && isset($definition['required']) && $definition['required']) {
			$containerID = self::referenceID($element->namespaceURI, $element->localName);
			if ($allChildren) {
				throw new \Exception("Missing required element in <$containerID>.");
			} else {
				$childID = self::referenceID($namespaceURI, $localName);
				throw new \Exception("Missing required element <$childID> in <$containerID>.");
			}
		}

		return $ret;
	}

	protected static function findChild(array &$definition, \DOMElement $element) {
		$children = self::findChildren($definition, $element);
		if (count($children) > 1) {
			$containerID = self::referenceID($element->namespaceURI, $element->localName);
			$childID = self::referenceID($definition['namespaceURI'], $definition['localName']);
			throw new \Exception("More than one <$childID> in <$containerID>.");
		}
		if (empty($children)) {
			return NULL;
		} else {
			return $children[0];
		}
	}

	protected function extractAttribute(array &$definition, \DOMElement $element) {
		assert('isset($definition["localName"])');

		$localName = $definition['localName'];
		if (isset($definition['namespaceURI'])) {
			$namespaceURI = $definition['namespaceURI'];
		} else {
			$namespaceURI = NULL;
		}

		if (!$element->hasAttributeNS($namespaceURI, $localName)) {
			if (isset($definition['required']) && $definition['required']) {
				$attributeID = self::referenceID($namespaceURI, $localName);
				$elementID = self::referenceID($element->namespaceURI, $element->localName);
				throw new \Exception("Missing required attribute '$attributeID' on <$elementID>.");
			} else {
				return NULL;
			}
		}

		$value = $element->getAttributeNS($namespaceURI, $localName);

		if (!isset($definition['attributeType'])) {
			return $value;
		}

		try {
			$value = call_user_func(array($definition['attributeType'], 'parse'), $value);
		} catch (\Exception $e) {
			$attributeID = self::referenceID($namespaceURI, $localName);
			$elementID = self::referenceID($element->namespaceURI, $element->localName);
			$msg = $e->getMessage();
			throw new \Exception("Error parsing attribute '$attributeID' on <$elementID>: $msg", 0, $e);
		}

		return $value;
	}

	protected function extractElement(array &$definition, \DOMElement $element) {
		$value = self::findChild($definition, $element);
		if ($value === NULL) {
			return NULL;
		}

		if (isset($definition['elementContext'])) {
			$elementContext = $definition['elementContext'];
		} else {
			$elementContext = NULL;
		}

		if (isset($definition['allowUnknown'])) {
			$allowUnknown = $definition['allowUnknown'];
		} else {
			$allowUnknown = NULL;
		}

		try {
			return \SimpleSAML\XML\Parser::parseXML($value);
		} catch (Exception $e) {
			$containerID = self::referenceID($element->namespaceURI, $element->localName);
			$childID = self::referenceID($definition['namespaceURI'], $definition['localName']);
			throw new \Exception("Unable to decode <$childID> in <$containerID>: " . $e->getMessage(), 0, $e);
		}
		return new $cls($value);
	}

	protected function extractElementList(array &$definition, \DOMElement $element) {
		$children = self::findChildren($definition, $element);

		if (isset($definition['elementContext'])) {
			$elementContext = $definition['elementContext'];
		} else {
			$elementContext = NULL;
		}

		if (isset($definition['allowUnknown'])) {
			$allowUnknown = $definition['allowUnknown'];
		} else {
			$allowUnknown = NULL;
		}

		$ret = array();
		foreach ($children as $child) {
			try {
				$ret[] = \SimpleSAML\XML\Parser::parseXML($child, $elementContext, $allowUnknown);
			} catch (Exception $e) {
				$containerID = self::referenceID($element->namespaceURI, $element->localName);
				$childID = self::referenceID($definition['namespaceURI'], $definition['localName']);
				throw new \Exception("Unable to decode <$childID> in <$containerID>: " . $e->getMessage(), 0, $e);
			}
		}

		return $ret;
	}

	protected function extractElementContent(array &$definition, \DOMElement $element) {
		$value = self::findChild($definition, $element);
		if ($value === NULL) {
			return NULL;
		}
		$value = $value->textContent;

		if (isset($definition['contentType'])) {
			try {
				$value = call_user_func(array($definition['contentType'], 'parse'), $value);
			} catch (\Exception $e) {
				$childID = self::referenceID($definition['namespaceURI'], $definition['localName']);
				$msg = $e->getMessage();
				throw new \Exception("Error parsing text content of <$childID>: $msg", 0, $e);
			}
		}

		return $value;
	}

	protected function extractElementContentList(array &$definition, \DOMElement $element) {
		$children = self::findChildren($definition, $element);
		$ret = array();
		foreach ($children as $child) {
			$value = $child->textContent;
			if (isset($definition['contentType'])) {
				try {
					$value = call_user_func(array($definition['contentType'], 'parse'), $value);
				} catch (\Exception $e) {
					$childID = self::referenceID($definition['namespaceURI'], $definition['localName']);
					$msg = $e->getMessage();
					throw new \Exception("Error parsing text content of <$childID>: $msg", 0, $e);
				}
			}
			$ret[] = $value;
		}

		return $ret;
	}

	protected function extractTextContent(array &$definition, \DOMElement $element) {
		$value = $element->textContent;

		if (isset($definition['contentType'])) {
			try {
				$value = call_user_func(array($definition['contentType'], 'parse'), $value);
			} catch (\Exception $e) {
				$elementID = self::referenceID($element->namespaceURI, $element->localName);
				$msg = $e->getMessage();
				throw new \Exception("Error parsing text content of <$elementID>: $msg", 0, $e);
			}
		}

		return $value;
	}

	protected function extractProperty(array &$definition, \DOMElement $element) {
		switch ($definition['type']) {
		case 'attribute':
			return $this->extractAttribute($definition, $element);
		case 'element':
			return $this->extractElement($definition, $element);
		case 'element_list':
			return $this->extractElementList($definition, $element);
		case 'element_content':
			return $this->extractElementContent($definition, $element);
		case 'element_content_list':
			return $this->extractElementContentList($definition, $element);
		case 'text_content':
			return $this->extractTextContent($definition, $element);
		default:
			assert('FALSE');
		}
	}

	protected function loadElement(\DOMElement $element) {
		foreach ($this->properties as $name => $val) {
			$this->properties[$name]['value'] = $this->extractProperty($this->properties[$name]['definition'], $element);
		}
	}


	protected function createElement(\DOMDocument $document) {

		foreach ($this->getClasses() as $cls) {
			if (isset($cls::$_localName) && isset($cls::$_namespaceURI)) {
				$prefix = \SimpleSAML\XML\Register::getPrefix($cls::$_namespaceURI);
				$qualifiedName = $prefix . ':' . $cls::$_localName;
				return $document->createElementNS($cls::$_namespaceURI, $qualifiedName);
			}
		}

		throw new \Exception('Could not determine localName and namespaceURI for new element of type ' . get_class($this) . '.');
	}

	protected function addAttribute(\DOMElement $element, array &$definition, $value) {
		$localName = $definition['localName'];
		if (isset($definition['namespaceURI'])) {
			$namespaceURI = $definition['namespaceURI'];
			$prefix = \SimpleSAML\XML\Register::getPrefix($namespaceURI);
			$qualifiedName = $prefix . ':' . $localName;
		} else {
			$namespaceURI = NULL;
			$qualifiedName = $localName;
		}

		if ($value === NULL) {
			if (isset($definition['required']) && $definition['required']) {
				$attributeID = self::referenceID($namespaceURI, $localName);
				$elementID = self::referenceID($element->namespaceURI, $element->localName);
				throw new \Exception("No value for required attribute '$attributeID' on <$elementID>.");
			} else {
				return;
			}
		}

		if (isset($definition['attributeType'])) {
			try {
				$value = call_user_func(array($definition['attributeType'], 'format'), $value);
			} catch (\Exception $e) {
				$attributeID = self::referenceID($namespaceURI, $localName);
				$elementID = self::referenceID($element->namespaceURI, $element->localName);
				$msg = $e->getMessage();
				throw new \Exception("Error formatting attribute '$attributeID' on <$elementID>: $msg", 0, $e);
			}
		}

		$element->setAttributeNS($namespaceURI, $qualifiedName, $value);
	}

	protected function addElement(\DOMElement $parent, array &$definition, $value) {
		assert('isset($definition["localName"]) && isset($definition["namespaceURI"])');

		$localName = $definition['localName'];
		$namespaceURI = $definition['namespaceURI'];

		if ($value === NULL) {
			if (isset($definition['required']) && $definition['required']) {
				$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
				$childID = self::referenceID($namespaceURI, $localName);
				throw new \Exception("No value for required element <$childID> in <$containerID>.");
			} else {
				return;
			}
		}

		$value->toXML($parent);
	}

	protected function addElementList(\DOMElement $parent, array &$definition, $values) {

		if (empty($values)) {
			if (isset($definition['required']) && $definition['required']) {
				$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
				if (isset($definition['allChildren']) && $definition['allChildren']) {
					throw new \Exception("No child element in <$containerID>.");
				} else {
					assert('isset($definition["localName"]) && isset($definition["namespaceURI"])');
					$localName = $definition['localName'];
					$namespaceURI = $definition['namespaceURI'];
					$childID = self::referenceID($namespaceURI, $localName);
					throw new \Exception("No value for required element <$childID> in <$containerID>.");
				}
			} else {
				return;
			}
		}

		foreach ($values as $value) {
			$value->toXML($parent);
		}
	}

	protected function addElementContent(\DOMElement $parent, array &$definition, $value) {
		assert('isset($definition["localName"]) && isset($definition["namespaceURI"])');

		$localName = $definition['localName'];
		$namespaceURI = $definition['namespaceURI'];

		if ($value === NULL) {
			if (isset($definition['required']) && $definition['required']) {
				$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
				$childID = self::referenceID($namespaceURI, $localName);
				throw new \Exception("No value for required element <$childID> in <$containerID>.");
			} else {
				return;
			}
		}

		if (isset($definition['contentType'])) {
			try {
				$value = call_user_func(array($definition['contentType'], 'format'), $value);
			} catch (\Exception $e) {
				$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
				$childID = self::referenceID($namespaceURI, $localName);
				$msg = $e->getMessage();
				throw new \Exception("Error formatting value for contents of <$childID> in <$containerID>: $msg", 0, $e);
			}
		}

		$document = $parent->ownerDocument;
		$prefix = \SimpleSAML\XML\Register::getPrefix($namespaceURI);
		$qualifiedName = $prefix . ':' . $localName;
		$element = $document->createElementNS($namespaceURI, $qualifiedName);
		$parent->appendChild($element);
		$element->appendChild($document->createTextNode($value));
	}


	protected function addElementContentList(\DOMElement $parent, array &$definition, $values) {
		assert('isset($definition["localName"]) && isset($definition["namespaceURI"])');

		$localName = $definition['localName'];
		$namespaceURI = $definition['namespaceURI'];

		if (empty($value)) {
			if (isset($definition['required']) && $definition['required']) {
				$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
				$childID = self::referenceID($namespaceURI, $localName);
				throw new \Exception("No value for required element <$childID> in <$containerID>.");
			} else {
				return;
			}
		}

		$document = $parent->ownerDocument;
		$prefix = \SimpleSAML\XML\Register::getPrefix($namespaceURI);
		$qualifiedName = $prefix . ':' . $localName;

		foreach ($values as $value) {
			if (isset($definition['contentType'])) {
				try {
					$value = call_user_func(array($definition['contentType'], 'format'), $value);
				} catch (\Exception $e) {
					$containerID = self::referenceID($parent->namespaceURI, $parent->localName);
					$childID = self::referenceID($namespaceURI, $localName);
					$msg = $e->getMessage();
					throw new \Exception("Error formatting value for contents of <$childID> in <$containerID>: $msg", 0, $e);
				}
			}

			$element = $document->createElementNS($namespaceURI, $qualifiedName);
			$parent->appendChild($element);
			$element->appendChild($document->createTextNode($value));
		}

	}


	protected function addTextContent(\DOMElement $parent, array &$definition, $value) {
		if ($value === NULL) {
			if (isset($definition['required']) && $definition['required']) {
				$elementID = self::referenceID($parent->$namespaceURI, $parent->$localName);
				throw new \Exception("No value for contents of <$elementID>.");
			} else {
				return;
			}
		}

		if (isset($definition['contentType'])) {
			try {
				$value = call_user_func(array($definition['contentType'], 'format'), $value);
			} catch (\Exception $e) {
				$elementID = self::referenceID($parent->$namespaceURI, $parent->$localName);
				$msg = $e->getMessage();
				throw new \Exception("Error formatting value for contents of <$elementID>: $msg", 0, $e);
			}
		}

		$tn = $parent->ownerDocument->createTextNode($value);
		$parent->appendChild($tn);
	}

	protected function addProperty(\DOMElement $element, array &$definition, $value) {
		switch ($definition['type']) {
		case 'attribute':
			$this->addAttribute($element, $definition, $value);
			break;
		case 'element':
			$this->addElement($element, $definition, $value);
			break;
		case 'element_list':
			$this->addElementList($element, $definition, $value);
			break;
		case 'element_content':
			$this->addElementContent($element, $definition, $value);
			break;
		case 'element_content_list':
			$this->addElementContentList($element, $definition, $value);
			break;
		case 'text_content':
			$this->addTextContent($element, $definition, $value);
			break;
		default:
			assert('FALSE');
		}
	}

	public function toXML($parent) {
		assert('$parent instanceof \DOMElement || $parent instanceof \DOMDocument');

		if ($parent instanceof \DOMDocument) {
			$doc = $parent;
		} else {
			$doc = $parent->ownerDocument;
		}

		$element = $this->createElement($doc);
		$parent->appendChild($element);

		foreach ($this->properties as $name => $property) {
			$this->addProperty($element, $property['definition'], $property['value']);
		}

		return $element;
	}


	public function __set($name, $value) {
		if (!isset($this->properties[$name])) {
			throw new Exception('Unknown property: ' . $name);
		}

		$this->properties[$name]['value'] = $value;
	}

	public function __get($name) {
		if (!isset($this->properties[$name])) {
			throw new Exception('Unknown property: ' . $name);
		}

		return $this->properties[$name]['value'];
	}

	public function __isset($name) {
		if (!isset($this->properties[$name])) {
			throw new Exception('Unknown property: ' . $name);
		}

		return isset($this->properties[$name]['value']);
	}

}
