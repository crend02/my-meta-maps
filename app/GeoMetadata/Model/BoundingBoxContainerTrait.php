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

namespace GeoMetadata\Model;

/**
 * Default implementation of the BoundingBoxContainer interface that allows to store bounding boxes.
 * There can be one bounding box (bbox) per coordinate reference system (CRS).
 */
trait BoundingBoxContainerTrait {
	
	private $boundingBox = array();

	/**
	 * Returns a new instance of a class implementing the BoundingBox interface and 
	 * which is is compatible with the implementation of the layer or metadata based class.
	 * 
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	public abstract function deliverBoundingBox();

	/**
	 * Returns a list of CRS names that the class has bounding boxes for.
	 * 
	 * @return array
	 */
	public function getCoordinateReferenceSystems() {
		return array_keys($this->getBoundingBox());
	}

	/**
	 * Checks whether there is a bbox for the given CRS or not.
	 * If you specify null as CRS you'll check whether there is generally any bbox available or not.
	 * 
	 * @param string $crs CRS name
	 * @return boolean true if a bbox exists, false otherwise.
	 */
	public function hasBoundingBox($crs = null) {
		$result = $this->getBoundingBox($crs);
		return !empty($result);
	}

	/**
	 * Returns the stored bbox for the given CRS.
	 * If you specify null as CRS you'll get the complete list of bboxes.
	 * 
	 * @param string $crs CRS name
	 * @return BoundingBox|array|null
	 */
	public function getBoundingBox($crs = null){
		if ($crs !== null) {
			return isset($this->boundingBox[$crs]) ? $this->boundingBox[$crs] : null;
		}
		else {
			return $this->boundingBox;
		}
	}
	
	/**
	 * Removed the bbox associated to the given CRS name from the list of bboxes.
	 * 
	 * @param string $crs CRS name
	 */
	public function removeBoundingBox($crs) {
		if ($this->hasBoundingBox($crs)) {
			unset($this->boundingBox[$crs]);
		}
	}
	
	/**
	 * Adds a bbox to the list of bboxes.
	 * 
	 * If there is already a bbox for the CRS associated to the bbox, the new bbox will replace
	 * the previously stored bbox.
	 *
	 * You can specify null as CRS which will do nothing. It's just more convenient than
	 * aloways checking for null before calling this method.
	 * 
	 * @param \GeoMetadata\Model\BoundingBox $bbox BBox to be added
	 */
	public function addBoundingBox(BoundingBox $bbox = null) {
		if ($bbox === null) {
			return;
		}
		$crs = $bbox->getCoordinateReferenceSystem();
		$this->boundingBox[$crs] = $bbox;
	}
	
	/**
	 * Creates a new bbox by calling deliverBoundingBox() and setting all given data to the new object.
	 * 
	 * The newly created object will be added to the list of bboxes and finally it's returned to be used.
	 * The new object might replace a previously existing bbox with the same CRS.
	 * 
	 * @see \GeoMetadata\Model\BoundingBoxContainer::addBoundingBox()
	 * @see \GeoMetadata\Model\BoundingBoxContainer::deliverBoundingBox()
	 * @param double $west Western edge of the bbox
	 * @param double $south Southern edge of the bbox
	 * @param double $east Eastern edge of the bbox
	 * @param double $north Northern edge of the bbox
	 * @param string $crs CRS name (can be an empty string)
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	public function createBoundingBox($west, $south, $east, $north, $crs = '') {
		$bbox = $this->deliverBoundingBox();
		$bbox->set($west, $south, $east, $north);
		$bbox->setCoordinateReferenceSystem($crs);
		$this->addBoundingBox($bbox);
		return $bbox;
	}

	/**
	 * Copies/clones a bbox and its attributes to a new object derived from \GeoMetadata\Model\BoundingBox.
	 * 
	 * The newly created object will be added to the list of bboxes and finally it's returned to be used.
	 * The new object might replace a previously existing bbox with the same CRS.
	 * 
	 * You can specify null as CRS which will always return null, but might be more convenient than
	 * aloways checking for null before calling this method.
	 * 
	 * @see \GeoMetadata\Model\BoundingBoxContainer::addBoundingBox()
	 * @see \GeoMetadata\Model\BoundingBoxContainer::deliverBoundingBox()
	 * @param \GeoMetadata\Model\BoundingBox $bbox BBox to copy/clone
	 * @return \GeoMetadata\Model\BoundingBox
	 */
	public function copyBoundingBox($bbox = null) {
		if ($bbox === null) {
			return null;
		}
		if (is_array($bbox)) {
			foreach ($bbox as $box) {
				if ($box !== null) { // Double check this to prevent an endless loop
					$this->copyBoundingBox($box);
				}
			}
			return $this->getBoundingBox();
		}
		else if ($bbox instanceof BoundingBox && $bbox->defined()) {
			return $this->createBoundingBox($bbox->getWest(), $bbox->getSouth(), $bbox->getEast(), $bbox->getNorth(), $bbox->getCoordinateReferenceSystem());
		}
	}

}