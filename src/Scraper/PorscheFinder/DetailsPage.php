<?php
/**
 * Created by PhpStorm.
 * User: user1624
 * Date: 17.12.2018
 * Time: 13:40
 */

namespace Imod\Scraper\PorscheFinder;


use Imod\Scraper\JsonScraper;

class DetailsPage extends \Imod\Scraper\DetailsPage {

	use JsonScraper;

	protected function getParserAlias() {
		return 'parser.porsche.detail_page';
	}

	protected function parseEditDate() {
		return '';
	}

	protected function parseTitle() {
		return implode(' ', [
			'Porsche',
			$this->getJsonData('vehicle.summary.title')
		]);
	}

	protected function parseBrand() {
		return 'Porsche';
	}

	protected function parseModel() {
		return $this->getJsonData('vehicle.modelSeries.name');
	}

	protected function parseExternalId() {
		return $this->getJsonData('offerKey');
	}

	protected function parsePrice() {
		return $this->getJsonData('price.value');
	}

	protected function parseImages() {
		$result = [];
//		var_export($this->jsonData['vehicle']['media'][1]);
		$images = $this->getJsonData('vehicle.media');
		if (!is_array($images)) {
			return $result;
		}
		foreach ($images as $imageData) {
			$width = 0;
			$url = '';
			if (!isset($imageData['mediaAsset']['image']['imageVariants'])) {
				continue;
			}
			foreach ($imageData['mediaAsset']['image']['imageVariants'] as $variant) {
				if ($variant['width'] > $width) {
					$url = $variant['url'];
				}
			}
			if (!$url) {
				continue;
			}
			$result[] = $url;
		}
		return $result;
	}

	protected function parseBuildDate($format) {
		try {
			$date = new \DateTime();
			$date->setTimestamp(round($this->getJsonData('vehicle.summary.registrationDate') / 1000));
			return intval($date->format($format));
		}
		catch (\Exception $e) {
			return '';
		}
	}

	protected function parseTaxDeductible() {
		return 0;
	}

	protected function parseTaxPercentage() {
		return 0;
	}

	protected function parseFuel() {
		return strtolower($this->getJsonData('vehicle.summary.engineType'));
	}

	protected function parseCo2Emissions() {
		$value = $this->getJsonData('vehicle.summary.emissions.value');
		return intval($this->pregMatch('/^(\d+)/', $value));
	}

	protected function parseVariant() {
		$result = $this->data['titel'];
		foreach (['merk', 'model', 'carrosserie'] as $field) {
			$result = str_ireplace($this->data[$field], '', $result);
		}
		$result = preg_replace('/(\s+)/', ' ', $result);
		$result = trim($result);
		return $result;
	}

	protected function parseTransmission() {
		return $this->getJsonData('vehicle.summary.transmission.optionTagKey');
	}

	protected function parseMillage() {
		return intval($this->getJsonData('vehicle.summary.mileage.value'));
	}

	protected function parseHorsePower() {
		$value = $this->getJsonData('vehicle.summary.power.value');
		return intval($this->pregMatch('/\/(\d+)/', $value));
	}

	protected function parseKwPower() {
		$value = $this->getJsonData('vehicle.summary.power.value');
		return intval($this->pregMatch('/^(\d+)/', $value));
	}

	protected function parseCylindersAmount() {
		return '?';
	}

	protected function parseCylindersCapacity() {
		return '?';
	}

	protected function parseDoorsNumber() {
		return '??';
	}

	protected function parseSeatsNumber() {
		return '??';
	}

	protected function parseFuelConsumptionCombined() {
		$value = $this->getJsonData('vehicle.summary.fuelConsumption.value');
		return floatval($this->pregMatch('/^(\d+)/', $value));
	}

	protected function parseFuelConsumptionCity() {
		return 0;
	}

	protected function parseFuelConsumptionHighway() {
		return 0;
	}

	protected function parseOptions() {
		$result = [];
		$equipments =  $this->getJsonData('vehicle.equipment.otherEquipment');
		if (!is_array($equipments)) {
			return $result;
		}
		foreach ($equipments as $equipment) {
			$result[] = $equipment['title'];
		}
		return $result;
	}

	protected function parseBodyType() {
		return '';
	}

	protected function parseExteriorColor() {
		return strtolower($this->getJsonData('vehicle.summary.exteriorColor.colorOptionTag.name'));
	}

	protected function parseInteriorColor() {
		return strtolower($this->getJsonData('vehicle.summary.interiorEquipment.colorOptionTag.name'));
	}

	protected function parseSellerAddress() {
		var_export($this->getJsonData('vehicle.summary.owningOrganisation.displayName'));
		$result = str_replace([PHP_EOL, $this->getJsonData('vehicle.summary.owningOrganisation.displayName')], [' ', ''], $this->getJsonData('vehicle.summary.owningOrganisation.postalAddress'));
		$result = trim(preg_replace('/\s+/', ' ', $result));
		return $result;
	}

	protected function parseSellerPhone() {
		return $this->getJsonData('vehicle.summary.owningOrganisation.telephoneNumber');
	}

	protected function parseSellerName() {
		return $this->getJsonData('vehicle.summary.owningOrganisation.companyName');
	}

	protected function parseCoating() {
		return '';
	}

	protected function parseToken() {
		return '';
	}


}