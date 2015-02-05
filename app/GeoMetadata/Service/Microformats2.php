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

use Mf2;

/**
 * Parser for Microformats2 (h-geo).
 * Code: mf2
 * 
 * For more information about the capabilities of this parser see the description here:
 * https://github.com/m-mohr/my-meta-maps/wiki/Metadata-Formats
 */
class Microformats2 extends CachedParser {
	
	use Traits\HttpGetTrait;
	
	const CRS = 'EPSG:4326';

	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url) {
		return $url;
	}

	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		return $url;
	}
	
	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return 'mf2';
	}
	
	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return 'microformats2';
	}

	/**
	 * Creates the internal parser instance that should be used for parsing. 
	 * 
	 * The object returned here will be cached for further usage.
	 * 
	 * @return \Mf2 $source Internal parser instance
	 */
	protected function createParser($source) {
		$parser = Mf2\parse($source);

		if (empty($parser['items'])) {
			// No data at all, return
			return null;
		}
		
		return $parser;
	}

	/**
	 * The given model will be filled with the parsed data.
	 * 
	 * @param \GeoMetadata\Model\Metadata $model Instance of the model to be filled with the parsed data.
	 * @return boolean true on success, false on failure
	 */
	protected function fillModel(\GeoMetadata\Model\Metadata &$model) {
		$json = $this->getParser();

		// Get all latitude and longitude values to calculate a bbox from them
		$lat = array();
		$lon = array();
		foreach ($json['items'] as $item) {
			if (isset($item['properties']) && !empty($item['properties']['latitude']) && !empty($item['properties']['longitude'])) {
				$lat[] = current($item['properties']['latitude']);
				$lon[] = current($item['properties']['longitude']);
			}
		}
		
		if (count($lat) == 0 || count($lon) == 0) {
			// No geodata available, return
			return false;
		}
		
		// Build the bounding box from the lon/lat values
		$model->createBoundingBox(min($lon), min($lat), max($lon), max($lat), self::CRS);
		
		// Trying to parse additional meta data
		if (isset($json['rels'])) {
			foreach ($json['rels'] as $key => $value) {
				switch(strtolower($key)) {
					case 'copyright':
						$model->setCopyright(current($value));
						break;
					case 'tag':
						$model->setKeywords($value);
						break;
					case 'contents':
						$model->setAbstract(current($value));
						break;
					case 'license':
						$model->setLicense(current($value));
						break;
					case 'author':
						$model->setAuthor(current($value));
						break;
				}
			}
		}

		return true;
	}

}