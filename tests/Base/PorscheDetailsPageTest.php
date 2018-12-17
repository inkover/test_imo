<?php
/**
 * Created by PhpStorm.
 * User: user1624
 * Date: 17.12.2018
 * Time: 13:44
 */

use Imod\Scraper\PorscheFinder\DetailsPage;

class PorscheDetailsPageTest extends PHPUnit_Framework_TestCase {

	/** @var \Imod\Scraper\AudiBoerse\DetailsPage */
	protected $scraper;

	protected function setUp() {

		$this->scraper = new DetailsPage();

	}

	protected function tearDown() {
		$this->scraper = null;
	}


	/**
	 * @dataProvider getUrls
	 * @param $url
	 * @param $result
	 */
	public function testUrl($url) {
		$this->assertInstanceOf(DetailsPage::class, $this->scraper->setUrl($url), 'Test URL set');
		$this->assertEquals($url, $this->scraper->getUrl(), 'Test URL set');
	}

	public function getUrls() {
		return [
			[null],
			['https://test']
		];
	}

	/**
	 * @dataProvider getScrapperData
	 * @param $url
	 * @param $data
	 */
	public function testScrapper($url, $data) {
		$this->assertInstanceOf(DetailsPage::class, $this->scraper->setUrl($url), 'Test URL set');
		$this->scraper->scrape();
		$parsedData = $this->scraper->getData();
		$dataKeys = array_keys($data);
		$parsedKeys = array_keys($parsedData);

		$optionalFields = ['bekleding', 'token'];

		sort($dataKeys);
		sort($parsedKeys);
		$this->assertEquals($dataKeys, $parsedKeys, 'Check keys same');
		foreach ($data as $key => $expected) {
			$this->assertTrue(array_key_exists($key, $parsedData), 'Check \'' . $key . '\' key exists');
			if (!in_array($key, $optionalFields)) {
				$this->assertTrue(isset($parsedData[$key]), 'Check \'' . $key . '\' has data');
			}
			$this->assertSame($expected, $parsedData[$key], 'Check \'' . $key . '\' key equals to \'' . $expected . '\'');
		}
	}

	public function getScrapperData() {
		$result = [
			[
				$this->getUrlPrefix() . '/api/offer/13258?marketPlaceKey=de',
				[
					'parser'                => 'parser.porsche.detail_page',
					'titel'                 => 'Porsche 918 Spyder m. Weissach-P.', //title
					'merk'                  => 'Porsche',//brand
					'model'                 => '918',//model
					'external_id'           => '13258',//external ID
					'prijs'                 => 1500000.0, //price of the car
					'brandstof'             => 'hybrid',//fuel
					'bouwjaar'              => 2015,//build year
					'bouwjaar_maand'        => 5,//build month
					'co2uitstoot'           => 70,//co2-emission
					'variant'               => 'Spyder m. Weissach-P.',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => 'pdk',//transmission
					'kilometerstand'        => 3500,//milage
					'vermogen_pk'           => 887,// Horse Power
					'vermogen_kw'           => 652,
					'aantal_cilinders'      => '?',//amount cilinders
					'cilinderinhoud'        => '?',//cilinder capacity
					'aantal_deuren'         => '??',//total doors
					'aantal_zitplaatsen'    => '??',//number seats
					'verbruik_gecombineerd' => 3.0,//fuel consumption combined
					'verbruik_stad'         => 0,//fuel consumption city
					'verbruik_snelweg'      => 0,//fuel consumption hightway
					'btw_verrekenbaar'      => 0,//tax deductable
					'btw_percentage'        => 0,//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '/api/offer/13258?marketPlaceKey=de',//weblink
					'uitrusting'            => [ //equipment/options


					],
					'verkoper_adres'        => 'Porscheplatz 9 70435 Stuttgart-Zuffenhausen',//seller address
					'verkoper_telefoon'     => '+49-711-911-26220',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => '??',//body type
					'kleur_exterieur'       => 'havannaschwarz',//color exterior
					'kleur_interieur'       => 'schwarz-schwarz',//color interior
					'handler'               => 'Porsche Zentrum Stuttgart',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [
					],
				]
			]
		];
		return [$result[0]];
//		return $result;
	}

	protected function getAddonHttpClientHeaders() {

	}

	protected function getUrlPrefix() {
		return 'https://finder.porsche.com/';
	}
}
