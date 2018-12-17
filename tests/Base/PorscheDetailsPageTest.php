<?php
/**
 * Created by PhpStorm.
 * User: user1624
 * Date: 17.12.2018
 * Time: 13:44
 */

use Imod\Scraper\PorscheFinder\DetailsPage;

class PorscheDetailsPageTest extends PHPUnit_Framework_TestCase {

	protected $jsonData = [
		'foo' => 234,
		'bar' => [
			['sss' => 'ddd']
		]
	];

	/** @var \Imod\Scraper\PorscheFinder\DetailsPage */
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
	 * @dataProvider getJsonData
	 * @param $path
	 * @param $value
	 */
	public function testJsonData($path, $value) {
		$this->assertSame($value, $this->scraper->getJsonData($path, $this->jsonData));
	}

	public function getJsonData() {
		return [
			[
				'foo',
				234
			],
			[
				'bar',
				[['sss' => 'ddd']]
			],
			[
				'bar.0.sss',
				'ddd'
			]
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
					'carrosserie'           => '',//body type
					'kleur_exterieur'       => 'white',//color exterior
					'kleur_interieur'       => 'black',//color interior
					'handler'               => 'Porsche Niederlassung Stuttgart GmbH',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/e5dcab21-5238-451c-947e-82d49e802880.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/506a5047-15a2-40fc-a35f-4ee3b5b5a027.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/c7bb0fce-b329-405d-9d6c-65f5bb01fd8d.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/a29232e6-ae45-4ea2-8cf1-d2fef23513a6.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/afb7ec49-7a64-4c9b-bb1e-6336c18f8100.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/9c6a8dda-b4da-41f6-a392-c293fe54f9d0.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/98965511-e686-42ec-af9f-e00f2a6c8502.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/2903127a-98b2-4d58-bfb7-2e691b4fbcb8.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/49d86d1b-6b43-40a5-95d4-f3106855d4fd.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/5fa1f4b5-e582-4217-85c3-617b6f15e254.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/ea0b8b28-102a-4cfe-9670-f5411991aa3b.jpg',
						'https://finder-files.porsche.com/finderimg/finder.porsche.com/2018/9/5/ba302707-0d78-4d10-891e-ad251b01a63c.jpg'
					],
				]
			]
		];
		return $result;
	}

	protected function getAddonHttpClientHeaders() {

	}

	protected function getUrlPrefix() {
		return 'https://finder.porsche.com/';
	}
}
