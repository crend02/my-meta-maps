<?php
/* 
 * Copyright 2014/15 Matthias Mohr
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GeoMetadata\Service;

use \GeoMetadata\GmRegistry;

/**
 * XML based Parser for GeoMetadata.
 * 
 * Note: When speaking about namespaces we are describing the namespace URI.
 */
abstract class XmlParser extends CachedParser {
	
	private $namespaces = array();
	private $usedNamespace;

	/**
	 * Creates the internal parser instance that should be used for parsing. 
	 * 
	 * The object returned here will be cached for further usage.
	 * 
	 * @return SimpleXMLElement $source Internal parser instance
	 */
	protected function createParser($source) {
		libxml_use_internal_errors(true); // Ignore error messages during parsing
		$node = simplexml_load_string($source);
		libxml_use_internal_errors(false);

		if (empty($node)) {
			$errors = libxml_get_errors();
			foreach ($errors as $error) {
				GmRegistry::log($error);
			}
			libxml_clear_errors();
			return null;
		}
		else {
			return $node;
		}
	}

	/**
	 * Sets the internal parser instance to be used for parsing.
	 * 
	 * @param mixed $parser
	 * @return Returns true on success, false on falure (e.g. if given instance is null).
	 */
	protected function setParser($parser) {
		$result = parent::setParser($parser);
		if ($result) {
			$this->registerNamespaces();
		}
		return $result;
	}

	/**
	 * Returns an array containing all supported namespaces by the implemnting parser.
	 * This can be also a string containing one single supported namespace.
	 * 
	 * @return array|string
	 */
	protected abstract function getSupportedNamespaces();
	
	/**
	 * Define the namespaces you want to use in XPath expressions.
	 * 
	 * You should register all namespaces with a prefix using the registerNamespace() method.
	 * 
	 * @see XmlParser::registerNamespace()
	 */
	protected abstract function registerNamespaces();

	/**
	 * Registers a namespace to a prefix that can be used in the methods implemented here.
	 * 
	 * Those prefixes are also registered for XPath queries.
	 * 
	 * @param string $prefix Namespace Prefix
	 * @param string $uri Namespace URI
	 */
	protected function registerNamespace($prefix, $uri) {
		$this->namespaces[$prefix] = $uri;
	}

	/**
	 * Returns all namespaces that are used for XPath queries.
	 * 
	 * @return array
	 */
	protected function getNamespaces() {
		return $this->namespaces;
	}
	
	/**
	 * Registers a namespace to a prefix that can be used in the methods implemented here.
	 * 
	 * Those prefixes are also registered for XPath queries.
	 * 
	 * @param string $prefix Namespace Prefix
	 * @param string $uri Namespace URI or empty string when not found.
	 */
	protected function getNamespace($prefix) {
		if (!isset($this->namespaces[$prefix])) {
			GmRegistry::log("Namespace for prefix '{$prefix}' not defined.");
			return '';
		}
		else {
			return $this->namespaces[$prefix];
		}
	}
	
	/**
	 * Get the namespace from list of namespaces that is used in the XML document.
	 * 
	 * @param string|array|null $namespaces string or array containing namespaces. If null, the list from getSupportedNamespaces() is used.
	 * @return string Namespace URI or an empty string if nothing was found.
	 */
	protected function getUsedNamespace($namespaces = null) {
		$isDefault = ($namespaces === null);
		if ($isDefault) {
			if ($this->usedNamespace !== null) {
				return $this->usedNamespace;
			}
			$namespaces = $this->getSupportedNamespaces();
		}
		$namespaces = !is_array($namespaces) ? array($namespaces) : $namespaces;

		$intersect = array_intersect($this->getParser()->getNamespaces(true), $namespaces);
		GmRegistry::log('Multiple namespaces found, falling back randomly.');
		$namespace = reset($intersect);
		$namespace = ($namespace === false ? '' : $namespace);
		if ($isDefault) {
			$this->usedNamespace = $namespace;
		}
		return $namespace;
	}
	
	/**
	 * Executes a XPath query.
	 * 
	 * @param string $path
	 * @param \SimpleXMLElement $parent
	 */
	public function xpath($path, \SimpleXMLElement $parent = null) {
		if ($parent == null) {
			$parent = $this->getParser();
		}
		
		$usedNs = $this->getUsedNamespace();
		$hasNamespace = !empty($usedNs);
		if ($hasNamespace) {
			foreach($this->getNamespaces() as $prefix => $uri) {
				$parent->registerXPathNamespace($prefix, $uri);
			}
		}
		
		return $parent->xpath($this->buildQuery($path, $hasNamespace));
	}
	
	/**
	 * Build the XPath expression from the path array.
	 * 
	 * @param array $path
	 * @param boolean $hasNamespace true to use namespaces, false otherwise.
	 * @return string XPath expression
	 */
	private function buildQuery(array $path, $hasNamespace = true) {
		// Remove namespace prefixes if no namespace is available.
		if (!$hasNamespace) {
			foreach($path as $pkey => $pvalue) {
				$conditions = explode('|', $pvalue); // Check each conditional (|)
				foreach ($conditions as $ckey => $cvalue) {
					$parts = explode(':', $cvalue, 2); // Split the parts into prefix and node name
					if (count($parts) == 2 && $parts[0] == $this->getCode()) {
						$conditions[$ckey] = $parts[1];
					}
				}
				$path[$pkey] = implode('|', $conditions);
			}
		}

		return '//' . implode('/', $path);
	}

	/**
	 * Converts a node to a string.
	 * 
	 * @param \SimpleXMLElement $node Node to convert
	 * @return string Textual content of the node
	 */
	protected function n2s(\SimpleXMLElement &$node = null) {
		if (is_object($node)) {
			return trim(strval($node));
		}
		else {
			return null;
		}
	}
	
	/**
	 * Select one node from the xml document.
	 * 
	 * @param array $path Parts of the XPath query, might have namespace prefixes followed by a double colon.
	 * @param \SimpleXMLElement $parent Parent node to start the search from (regarding the XPath query specified as first parameter).
	 * @param boolean $string Return the selected nodes as text (true) or as SimpleXML nodes (false).
	 * @return mixed
	 */
	protected function selectOne(array $path, \SimpleXMLElement $parent = null, $string = true) {
		$nodes = $this->xpath($path, $parent);
		$node = reset($nodes);
		if ($node === false) {
			$node = null;
		}
		else if ($string) {
			$node = $this->n2s($node);
		}
		return $node;
	}

	/**
	 * Select many nodes as array from the xml document.
	 * 
	 * @param array $path Parts of the XPath query, might have namespace prefixes followed by a double colon.
	 * @param \SimpleXMLElement $parent Parent node to start the search from (regarding the XPath query specified as first parameter).
	 * @param boolean $string Return the selected nodes as text (true) or as SimpleXML nodes (false).
	 * @return array
	 */
	protected function selectMany(array $path, \SimpleXMLElement $parent = null, $string = true) {
		$nodes = $this->xpath($path, $parent);
		$data = array();
		foreach ($nodes as $node) {
			if ($string) {
				$node = $this->n2s($node);
			}
			// Add nodes or non-empty strings
			if (!$string || !empty($node)) {
				$data[] = $node;
			}
		}
		return $data;
	}
	
	/**
	 * Returns one or many attributes from a node.
	 * 
	 * Returns an array where the key is the attribute name and the value the attribute value itself.
	 * 
	 * @param \SimpleXMLElement $node Node to use
	 * @param string $ns Namespace to use
	 * @return array Attributes
	 */
	protected function selectAttributes(\SimpleXMLElement $node, $ns = '') {
		$data = array();
		if (is_object($node)) {
			// To avoid the "Node no longer exists" error we need to copy the elements to an separate array.
			foreach ($node->attributes($ns) as $key => $value) {
				$data[$key] = trim((string) $value);
			}
		}
		return $data;
	}
	
	/**
	 * Returns the textual content of the node as hierarchically structured text.
	 * 
	 * Prepends the node names in front of the text content itself. Text is indented by tabs. Nodes
	 * without content are ignored.
	 * 
	 * @param array $path Parts of the XPath query, might have namespace prefixes followed by a double colon.
	 * @param string $namespace Namespace to use for the children
	 * @param \SimpleXMLElement $parent Parent node to start the search from (regarding the XPath query specified as first parameter).
	 * @return string|null Returns null on failure or if no text is found, otherwise a string.
	 */
	protected function selectNestedText(array $path, $namespace = '', \SimpleXMLElement $parent = null) {
		$node = $this->selectOne($path, $parent, false);
		if ($node != null) {
			$output = rtrim($this->nodeToNestedText($node, $namespace)); // Get text and remove the trailing newline
			if (empty($output)) {
				$output = null;
			}
			return $output;
		}
		else {
			return null;
		}
	}
	
	/**
	 * Recursive function that is used by selectNestedText to build the nested text.
	 * 
	 * @see XmlParser::selectNestedText()
	 * @param \SimpleXMLElement $node Node to get the text from.
	 * @param string $namespace Namespace to use for the children.
	 * @param string $output The current state of the parsed text.
	 * @param int $level Level of indentation and recursion.
	 * @return string Parsed text
	 */
	private function nodeToNestedText(\SimpleXMLElement $node, $namespace, $output = "", $level = 0) {
		foreach ($node->children($namespace) as $key => $value) {
			$children = $value->children($namespace);
			$output .= str_repeat("\t", $level);
			if (count($children) == 0) {
				$value = trim((string) $value);
				if (!empty($value)) {
					$output .= "{$key}: {$value}\r\n";
				}
			}
			else {
				$output .= $value->getName() . "\r\n";
				$output = $this->nodeToNestedText($value, $namespace, $output, $level + 1);
			}
		}

		return $output;
	}

}