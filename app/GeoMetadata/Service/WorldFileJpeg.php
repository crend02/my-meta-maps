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
 * Reads the metadata from a JPEG file with a world file.
 */
class WorldFileJpeg extends WorldFileImage {

	/**
	 * Returns the name of the file format.
	 * 
	 * @return string
	 */
	public function getFileTypeName() {
		return 'JPEG';
	}

	/**
	 * Returns the file extension for the image file without a leading dot in lower case.
	 * 
	 * @return string
	 */
	public function getImageFileExtension() {
		return 'jpg';
	}

	/**
	 * Returns the file extension for the world file without a leading dot in lower case.
	 * 
	 * @return string
	 */
	public function getWorldFileExtension() {
		return 'jpw';
	}

	/**
	 * Queries the image for information about metadata, width and height.
	 * 
	 * Returns an array with the width as first element and the height as second element.
	 * The metadata is returned as third element and is an associative array.
	 * 
	 * This method retrieves the JPEG width and height without downloading/reading the entire image.
	 * 
	 * This code is based on a code snippet from a user contribuited note on php.net, 
	 * see "author" and "see" tags of this method for further information.
	 * 
	 * @param string $url URL to the image file
	 * @return array|null
	 * @author james dot relyea at zifiniti dot com
	 * @see http://php.net/getimagesize
	 */
	public function getImageData($url) {
		$handle = @fopen($url, "rb");
		$new_block = NULL;
		if ($handle !== false && !feof($handle)) {
			$new_block = fread($handle, 32);
			$i = 0;
			if ($new_block[$i] == "\xFF" && $new_block[$i + 1] == "\xD8" && $new_block[$i + 2] == "\xFF" && $new_block[$i + 3] == "\xE0") {
				$i += 4;
				if ($new_block[$i + 2] == "\x4A" && $new_block[$i + 3] == "\x46" && $new_block[$i + 4] == "\x49" && $new_block[$i + 5] == "\x46" && $new_block[$i + 6] == "\x00") {
					// Read block size and skip ahead to begin cycling through blocks in search of SOF marker
					$block_size = unpack("H*", $new_block[$i] . $new_block[$i + 1]);
					$block_size = hexdec($block_size[1]);
					while (!feof($handle)) {
						$i += $block_size;
						$new_block .= fread($handle, $block_size);
						if ($new_block[$i] == "\xFF") {
							// New block detected, check for SOF marker
							$sof_marker = array("\xC0", "\xC1", "\xC2", "\xC3", "\xC5", "\xC6", "\xC7", "\xC8", "\xC9", "\xCA", "\xCB", "\xCD", "\xCE", "\xCF");
							if (in_array($new_block[$i + 1], $sof_marker)) {
								// SOF marker detected. Width and height information is contained in bytes 4-7 after this byte.
								$size_data = $new_block[$i + 2] . $new_block[$i + 3] . $new_block[$i + 4] . $new_block[$i + 5] . $new_block[$i + 6] . $new_block[$i + 7] . $new_block[$i + 8];
								$unpacked = unpack("H*", $size_data);
								$unpacked = $unpacked[1];
								$height = hexdec($unpacked[6] . $unpacked[7] . $unpacked[8] . $unpacked[9]);
								$width = hexdec($unpacked[10] . $unpacked[11] . $unpacked[12] . $unpacked[13]);
								return array($width, $height, array());
							}
							else {
								// Skip block marker and read block size
								$i += 2;
								$block_size = unpack("H*", $new_block[$i] . $new_block[$i + 1]);
								$block_size = hexdec($block_size[1]);
							}
						}
						else {
							return null;
						}
					}
				}
			}
		}
		return null;
	}

}
