<?php

namespace SimpleSAML\OOXML;

class AltSerializer {

	protected $register;

	public function __construct($register = NULL) {
		if ($register === NULL) {
			$register = Register::getDefault();
		}
		$this->register = $register;
	}

	protected function addAttributes(AltSerializationContext $context, &$target, Element $element) {
		foreach ($element->attributes as $name => $value) {
			if ($name[0] !== '{') {
				/* Not namespace prefixed attribute. */
				$qName = $name;
			} else {
				$nsEndPos = strpos($name, '}', 1);
				assert('$nsEndPos !== FALSE');
				$namespaceURI = substr($name, 1, $nsEndPos - 1);
				$localName = substr($name, $nsEndPos + 1);
				$qName = $context->qName($namespaceURI, $localName);
			}
			$target .= ' ' . $qName . '="' . htmlspecialchars($value) . '"';
		}
	}

	protected function addChildren(AltSerializationContext $context, &$target, Element $element) {
		foreach ($element->children as $child) {
			if (is_string($child)) {
				$target .= htmlspecialchars($child);
			} elseif ($child instanceof Element) {
				$this->processElement($context, $target, $child);
			} else {
				/* Unknown child type. */
				assert('FALSE');
			}
		}
	}


	protected function processElement(AltSerializationContext $context, &$target, Element $element) {
		$qName = $context->qName($element->namespaceURI, $element->localName);
		$target .= '<' . $qName;
		$this->addAttributes($context, $target, $element);

		if (!$element->children) {
			$target .= '/>';
			return;
		} else {
			$target .= '>';
		}

		$this->addChildren($context, $target, $element);
		$target .= '</' . $qName . '>';
	}

	protected function processRootElement(AltSerializationContext $context, Element $element) {
		$children = '';
		$this->addChildren($context, $children, $element);

		$qName = $context->qName($element->namespaceURI, $element->localName);
		$target = '<' . $qName;
		$this->addAttributes($context, $target, $element);

		foreach ($context->namespaces as $namespaceURI => $prefix) {
			$target .= ' xmlns:' . $prefix . '="' . htmlspecialchars($namespaceURI) . '"';
		}

		if ($children) {
			$target .= '>' . $children . '</' . $qName . '>';
		} else {
			$target .= '/>';
		}

		return $target;
	}

	public function findNamespaces(Element $element) {
	}

	public function serialize(Element $element) {
		$context = new AltSerializationContext($this->register);
		return $this->processRootElement($context, $element);
	}

}
