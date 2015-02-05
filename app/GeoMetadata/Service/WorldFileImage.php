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

/**
 * Base class for images that are delivered with a world file.
 */
abstract class WorldFileImage implements Parser {
	
	use Traits\HttpGetTrait;
	
	const CRS = 'EPSG:4326';
	
	/**
	 * Creates a new parser object that caches an internally used parser for multiple use (e.g. verify and parse).
	 * 
	 * @return Parser
	 */
	public function createObject() {
		return new static();
	}

	/**
	 * Returns the internal name of the parser.
	 * 
	 * Should be unique across all parsers.
	 * 
	 * @return string Internal type name of the parser.
	 */
	public function getCode() {
		return $this->getWorldFileExtension();
	}

	/**
	 * Returns the displayable name of the parser.
	 * 
	 * @return string Name of the parser
	 */
	public function getName() {
		return $this->getFileTypeName() . ' (*.' . $this->getImageFileExtension() . ' + *.' . $this->getWorldFileExtension() . ')';
	}
	
	/**
	 * Returns the name of the file format.
	 * 
	 * @return string
	 */
	public abstract function getFileTypeName();
	
	/**
	 * Returns the file extension for the image file without a leading dot in lower case.
	 * 
	 * @return string
	 */
	public abstract function getImageFileExtension();

	/**
	 * Returns the file extension for the world file without a leading dot in lower case.
	 * 
	 * @return string
	 */
	public abstract function getWorldFileExtension();
	
	/**
	 * Takes the user specified URL and builds the service (or base) url from it.
	 * 
	 * @param string $url URL
	 * @return string Base URL of the service
	 */
	public function getServiceUrl($url) {
		return $this->getBaseUrl($url) . $this->getImageFileExtension();
	}
	
	/**
	 * Takes the user specified URL and builds the metadata url of the service from it.
	 * 
	 * @param string $url URL
	 * @return string URL giving the metadata for the service
	 */
	public function getMetadataUrl($url) {
		return $this->getBaseUrl($url) . $this->getWorldFileExtension();
	}
	
	/**
	 * Returns the given URL without query string and without file extension, but includes the dot.
	 * 
	 * If the URL has not file extension the given URL is returned as is.
	 * 
	 * @param string $url URL to parse
	 * @return string
	 */
	protected function getBaseUrl($url) {
		if (preg_match('~^(https?://[^/?]+/[^?]+\.)[a-z]+(?:\?.*)?$~i', $url, $match)) {
			return $match[1];
		}
		else {
			return $url;
		}
	}
	
	/**
	 * Checks whether the given service data is of this type.
	 * 
	 * @param string $source String containing the data to parse.
	 * @return boolean true if content can be parsed, false if not.
	 */
	public function verify($source) {
		return ($this->getWorldFileData($source) !== null);
	}
	
	/**
	 * Queries the image for information about metadata, width and height.
	 * 
	 * Returns an array with the width as first element and the height as second element.
	 * The metadata is returned as third element and is an associative array.
	 * 
	 * @param string $url URL to the image file
	 * @return array|null
	 */
	public function getImageData($url) {
		$imageData = @getimagesize($url); // @ = Surpess PHP notices that could be thrown
		if ($imageData !== false && !empty($imageData[0]) && !empty($imageData[1])) {
			return array($imageData[0], $imageData[1], array());
		}
		// TODO: Parse the IPTC and/or exif information from the image file to get more metadata
		return null;
	}
	
	/**
	 * Parses the data.
	 * 
	 * @param string $source String containing the data to parse.
	 * @param GeoMetadata\Model\Metadata $model An instance of a model class to fill with the data.
	 * @return boolean true on success, false on failure.
	 */
	public function parse($source, \GeoMetadata\Model\Metadata &$model) {
		$url = $model->getUrl();
		
		// Title (from the file name)
		$title = rawurldecode(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME));
		$model->setTitle($title);
		
		// Bounding box (from the world file)
		$imageData = $this->getImageData($url);
		if ($imageData !== null) {
			$bbox = $this->calculeateBoundingBox($source, $imageData[0], $imageData[1]);
			$model->createBoundingBox($bbox['west'], $bbox['south'], $bbox['east'], $bbox['north'], self::CRS);
			return true;
		}

		return false;
	}
	
	/**
	 * Returns an array with six elements, each is the numerical value of the corresponsing line in the world file.
	 * 
	 * In case of an error null is returned.
	 * 
	 * @param string $source World file contents to parse
	 * @return array|null
	 */
	protected function getWorldFileData($source) {
		$lines = preg_split('~(\r\n|\r|\n)~', $source);
		if (count($lines) >= 6) {
			$data = array();
			for ($i = 0; $i < 6; $i++) {
				if (is_numeric($lines[$i])) {
					$data[$i] = floatval($lines[$i]);
				}
				else {
					return null;
				}
			}
			return $data;
		}
		return null;
	}
	
	/**
	 * Returns an array with west, south, east, north keys and their values of the bounding box 
	 * calculated from the given world file content.
	 * 
	 * In case of an error null is returned.
	 * 
	 * @param string $source World file contents to parse
	 * @param int Swidth Width of the image pixels
	 * @param int $height Height of the image in pixels
	 * @return array|null
	 */
	protected function calculeateBoundingBox($world, $width, $height) {
		// We assume that the world files are in UTM or WGS 84 lat/lon.
		$metadata = $this->getWorldFileData($world);
		// Make sure it's negative
		$metadata[3] = abs($metadata[3]) * -1;
		// Try to guess whether it's UTM or lat/lon
		$data = array(
			'west' => $metadata[4],
			'south' => $metadata[5] - ($height * $metadata[3]),
			'east' => $metadata[4] + ($width * $metadata[0]),
			'north' => $metadata[5]
		);
		if ($metadata[4] < 180 || $metadata[4] > 180 || $metadata[5] < 90 || $metadata[5] > 90) {
			// We guess it's UTM - convert it
			$data['west'] = $this->x2lon($data['west']);
			$data['south'] = $this->y2lat($data['south']);
			$data['east'] = $this->x2lon($data['east']);
			$data['north'] = $this->y2lat($data['north']);
		}
		return $data;
	}
	
	protected function x2lon($x) {
		return rad2deg($x / 6378137.0);
	}

	protected function y2lat($y) {
		return rad2deg(2.0 * atan(exp($y / 6378137.0)) - M_PI_2);
	}

}
