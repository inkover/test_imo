<?php

namespace Imod\Scraper\AudiBoerse;

use function foo\func;
use Symfony\Component\DomCrawler\Crawler;

class DetailsPage extends \Imod\Scraper\DetailsPage {

	protected $modelName;

	protected $bodyType;

	public function getModelName() {
		return $this->modelName;
	}

	public function setModelName($modelName) {
		$this->modelName = $modelName;
		return $this;
	}

	public function getBodyType() {
		return $this->bodyType;
	}

	public function setBodyType($bodyType) {
		$this->bodyType = $bodyType;
		return $this;
	}

	protected function getParserAlias() {
		return 'parser.audi.detail_page';
	}

	protected function getHighlights($name) {
		return strtolower($this->getFromCrawler($this->crawler->filter('section[data-module="highlights"] dl.module-highlights-item-' . $name . '>dd')));
	}

	protected function getTechData($name) {
		return strtolower($this->getFromCrawler($this->crawler->filter('section[data-module="technical-data"] dl:contains("' . $name . '")')->filter('dd')));
	}

	protected function parseEditDate() {
		return time();
	}

	protected function parseTitle() {
		return $this->getFromCrawler($this->crawler->filter('h1.vtp-title'));
	}

	protected function parseBrand() {
		return 'Audi';
	}

	protected function parseModel() {
		return $this->getModelName();
	}

	protected function parseExternalId() {
		$url = $this->getUrl();
		$path = parse_url($url, PHP_URL_PATH);
		$file = pathinfo($path, PATHINFO_FILENAME);
		$fileParts = explode('_', $file, 2);
		return $fileParts[1];
	}

	protected function parsePrice() {
		return intval($this->getFromCrawler($this->crawler->filter('meta[itemprop=price]'), 'content'));
	}

	protected function parseImages() {
		$result = [];
		$this->crawler->filter('ul.vtp-stage-gallery-content li.vtp-stage-gallery-item picture.picture img')->each(function(Crawler $img) use ($result) {
			$result[] = $img->attr('srcset');
		});
		return $result;
	}

	protected function parseBuildDate($format) {
		$regDate = $this->getHighlights('registration');
		if (!$regDate) {
			return '';
		}
		$date = new \DateTime($regDate);
		return intval($date->format($format));
	}

	protected function parseTaxDeductible() {
		return $this->getTechData('Jahressteuer für dieses Fahrzeug');
	}

	protected function parseTaxPercentage() {
		$taxSum = $this->data['btw_verrekenbaar'];
		if (!$taxSum) {
			return 0;
		}
		return round($taxSum / $this->data['prijs'] * 100);
	}

	protected function parseFuel() {
		return $this->getHighlights('fuel');
	}

	protected function parseCo2Emissions() {

		return intval($this->pregMatch('/^([\d]+) g\/km/', trim($this->getTechData('Emissionen komb.'))));
	}

	protected function parseVariant() {
		$result = $this->data['titel'];
		var_export($result);
		foreach (['merk', 'model', 'carrosserie'] as $field) {
			$result = str_replace($this->data[$field], '', $result);
		}
		$result = preg_replace('/(\s+)/', ' ', $result);
		$result = trim($result);
		return $result;
	}

	protected function parseTransmission() {
		return $this->getHighlights('transmission');
	}

	protected function parseMillage() {
		$result = $this->getHighlights('mileage');
		$result = preg_replace('([^\d]+)', '', $result);
		return intval($result);
	}

	protected function parseHorsePower() {
		return intval($this->pregMatch('/\(([\d]+)\s*PS\)/ui', $this->getHighlights('ps')));
	}

	protected function parseKwPower() {
		return intval($this->pregMatch('/([\d]+)\s*kw/ui', $this->getHighlights('ps')));
	}

	protected function parseCylindersAmount() {
		$result = ($this->pregMatch('/([\d])\s*\-?\s*zylinder/ui', $this->getTechData('Motorbauart')));
		if (!$result) {
			return '';
		}
		return intval($result);
	}

	protected function parseCylindersCapacity() {
		return intval($this->pregMatch('/^([\d]+)/', trim($this->getTechData('Hubraum'))));
	}

	protected function parseDoorsNumber() {
		return '?';
	}

	protected function parseSeatsNumber() {
		return '?';
	}

	protected function parseFuelConsumptionCombined() {
		return floatval(str_replace(',', '.', $this->getHighlights('consumption')));
	}

	protected function parseFuelConsumptionCity() {
		return floatval(str_replace(',', '.', $this->getTechData('innerorts')));
	}

	protected function parseFuelConsumptionHighway() {
		return floatval(str_replace(',', '.', $this->getTechData('außerorts')));
	}

	protected function parseOptions() {
		$result = [];
		$this->crawler->filter('div.vtp-feature-teasers article.vtp-feature-teaser div.text, div.vtp-description-list-wrap dd')->each(function (Crawler $crawler) use ($result) {
			$result[] = $crawler->text();
		});
		var_export($result);die();
		return $result;
	}

	protected function parseBodyType() {
		return $this->getBodyType();
	}

	protected function parseExteriorColor() {
		return $this->getHighlights('exterior-color');
	}

	protected function parseInteriorColor() {
		return $this->getHighlights('interior-color');
	}

	protected function parseSellerAddress() {
		return $this->getFromCrawler($this->crawler->filter('div.vtp-dealer-info-box div.address'));
	}

	protected function parseSellerPhone() {
		return $this->getFromCrawler($this->crawler->filter('div.vtp-dealer-info-box div.phone a.needsclick'));
	}

	protected function parseSellerName() {
		return $this->getFromCrawler($this->crawler->filter('div.vtp-dealer-info-box div.name'));
	}

	protected function parseCoating() {
		return '?';
	}

	protected function parseToken() {
		return '?';
	}


}