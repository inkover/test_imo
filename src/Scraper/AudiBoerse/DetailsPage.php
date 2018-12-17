<?php

namespace Imod\Scraper\AudiBoerse;

use Symfony\Component\DomCrawler\Crawler;

class DetailsPage extends \Imod\Scraper\DetailsPage {

	protected $originalId;

	protected $modelName;

	protected $bodyType;

	protected $featuresCrawler;

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

    protected function getOriginalId()
    {
        if (is_null($this->originalId)) {
            $url = $this->getUrl();
            $path = parse_url($url, PHP_URL_PATH);
            $file = pathinfo($path, PATHINFO_FILENAME);
            $fileParts = explode('_', $file, 2);
            $this->originalId = $fileParts[1];
        }
        return $this->originalId;
	}

	protected function getHighlights($name) {
		return strtolower($this->getFromCrawler($this->crawler->filter('section[data-module="highlights"] dl.module-highlights-item-' . $name . '>dd')));
	}

	protected function getTechData($name) {
		return strtolower($this->getFromCrawler($this->crawler->filter('section[data-module="technical-data"] dl:contains("' . $name . '")')->filter('dd')));
	}

    protected function getFeaturesCrawler() {
        if (is_null($this->featuresCrawler)) {
            $url = 'https://www.audi-boerse.de/gebrauchtwagen/i/d|' . $this->getOriginalId() . '/controller.htm?act=offer&v=10';
            $httpClient = $this->getHttpClient();
            $response = $httpClient->get($url);
            $this->featuresCrawler = new Crawler($response->getBody()->getContents());
        }
        return $this->featuresCrawler;
	}

	protected function getSellerAddressData($dataName) {
		return $this->getFromCrawler($this->crawler->filter('div.vtp-dealer-info-box span[itemprop="address"]>meta[itemprop="' . $dataName . '"]'), 'content');
	}

	protected function parseEditDate() {
		return '';
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
		return $this->getOriginalId();
	}

	protected function parsePrice() {
		return intval($this->getFromCrawler($this->crawler->filter('meta[itemprop=price]'), 'content'));
	}

	protected function parseImages() {
		$result = [];
		$this->crawler->filter('ul.vtp-stage-gallery-content li.vtp-stage-gallery-item picture.picture img')->each(function(Crawler $img) use (&$result) {
			$result[] = $img->attr('srcset');
		});
		return $result;
	}

	protected function parseBuildDate($format) {
		$regDate = $this->getHighlights('registration');
		if (!$regDate) {
			return '';
		}
		try {
			$date = new \DateTime($regDate);
			return intval($date->format($format));
		}
		catch (\Exception $e) {
			return '';
		}
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

		return intval($this->pregMatch('/^([\d]+) g\/km/', $this->getTechData('Emissionen komb.')));
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
		return intval($this->pregMatch('/^([\d]+)/', $this->getTechData('Hubraum')));
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
		$this->getFeaturesCrawler()->filter('div.vtp-feature-teasers article.vtp-feature-teaser div.text, div.vtp-description-list-wrap dd')->each(function (Crawler $crawler) use (&$result) {
			$result[] = trim($crawler->text());
		});
		return $result;
	}

	protected function parseBodyType() {
		return strtolower($this->getBodyType());
	}

	protected function parseExteriorColor() {
		return $this->getHighlights('exterior-color');
	}

	protected function parseInteriorColor() {
		return $this->getHighlights('interior-color');
	}

	protected function parseSellerAddress() {
		return implode(' ', [
			$this->getSellerAddressData('streetAddress'),
			$this->getSellerAddressData('postalCode'),
			$this->getSellerAddressData('addressLocality'),
		]);
	}

	protected function parseSellerPhone() {
		return $this->getSellerAddressData('telephone');
	}

	protected function parseSellerName() {
		return $this->getFromCrawler($this->crawler->filter('div.vtp-dealer-info-box div.name'));
	}

	protected function parseCoating() {
		return '';
	}

	protected function parseToken() {
		return '';
	}


}