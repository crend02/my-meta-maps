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

use \GeoMetadata\GmRegistry;
use \GeoMetadata\GeoMetadata;

/**
 * Tests for the GeoMetadata parsers/services.
 */
class ParserTest extends TestCase {
	
  /**
	 * Default preparation for each test
	 */
	public function setUp() {
		parent::setUp();
		
		GmRegistry::registerService(new \GeoMetadata\Service\Kml());
		GmRegistry::registerService(new \GeoMetadata\Service\Microformats2());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcCatalogueService());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebCoverageService());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebFeatureService());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcSensorObservationService());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapService());
		GmRegistry::registerService(new \GeoMetadata\Service\OgcWebMapTileService());

		GmRegistry::setLogger(array('Log', 'debug'));
		GmRegistry::setProxy(Config::get('remote.proxy.host'), Config::get('remote.proxy.port'));
	}

	/**
	 * Tests the Microformats parser.
	 * 
	 * @see \GeoMetadata\Service\Microfotmats
	 */
	public function testMicroformats() {
		$gm = GeoMetadata::withData($this->getExampleData('microformats.html'));
		$this->assertNotNull($gm);
		$model = $gm->parse();
		$this->assertNotNull($model);
		$this->assertEquals('http://www.microformats.org/copyright', $model->getCopyright());
		$this->assertCount(2, $model->getKeywords());
		$this->assertContains('http://microformats.org/wiki/', $model->getKeywords());
		$this->assertContains('http://microformats.org/wiki/microformats-2#h-geo', $model->getKeywords());
		$this->assertEquals('http://www.microformats.org/toc', $model->getAbstract());
		$this->assertEquals('http://www.microformats.org/license', $model->getLicense());
		$this->assertEquals('http://www.microformats.org/author', $model->getAuthor());
		$this->assertEquals(
			'POLYGON((-4.076148 54.155278,-4.076148 53.069406,-2.249722 53.069406,-2.249722 54.155278,-4.076148 54.155278))',
			$model->getBoundingBox(\GeoMetadata\Service\Microformats2::CRS)->toWkt()
		);
	}
	
	private function getExampleData($name) {
		$path = $this->path() . "/assets/parser/{$name}";
		return file_get_contents($path);
	}

}
