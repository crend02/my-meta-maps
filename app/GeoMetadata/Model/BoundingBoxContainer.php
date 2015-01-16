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

interface BoundingBoxContainer {

	public function getCoordinateReferenceSystems();
	public function hasBoundingBox($crs = null);
	public function getBoundingBox($crs = null);
	public function setBoundingBox(BoundingBox $bbox = null);
	public function removeBoundingBox($crs);
	public function createBoundingBox($west, $south, $east, $north, $crs = '');
	public function copyBoundingBox($bbox = null);

}