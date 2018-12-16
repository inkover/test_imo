<?php
/**
 * Created by PhpStorm.
 * User: Inkover
 * Date: 16.12.2018
 * Time: 19:52
 */


class AudiDetailsPageTest extends PHPUnit_Framework_TestCase {

	/** @var \Imod\Scraper\AudiBoerse\DetailsPage */
	protected $scraper;

	protected function setUp() {

		$this->scraper = new \Imod\Scraper\AudiBoerse\DetailsPage();

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
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\DetailsPage::class, $this->scraper->setUrl($url), 'Test URL set');
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
	public function testScrapper($url, $modelName, $bodyType, $data) {
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\DetailsPage::class, $this->scraper->setUrl($url), 'Test URL set');
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\DetailsPage::class, $this->scraper->setModelName($modelName), 'Test Model name set');
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\DetailsPage::class, $this->scraper->setBodyType($bodyType), 'Test Body type set');
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
				$this->getUrlPrefix() . '177ps-frontantrieb-schwarz-2_DEU43231003415.htm',
				'A6',
				'Limousine',
				[
					'parser'                => 'parser.audi.detail_page',
					'titel'                 => 'Audi A6 Limousine', //title
					'merk'                  => 'Audi',//brand
					'model'                 => 'A6',//model
					'external_id'           => 'DEU43231003415',//external ID
					'prijs'                 => 18480, //price of the car
					'brandstof'             => 'diesel',//fuel
					'bouwjaar'              => 2012,//build year
					'bouwjaar_maand'        => 7,//build month
					'co2uitstoot'           => 129,//co2-emission
					'variant'               => '',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => 'handschaltung',//transmission
					'kilometerstand'        => 66487,//milage
					'vermogen_pk'           => 177,// Horse Power
					'vermogen_kw'           => 130,
					'aantal_cilinders'      => 4,//amount cilinders
					'cilinderinhoud'        => 1968,//cilinder capacity
					'aantal_deuren'         => '?',//total doors
					'aantal_zitplaatsen'    => '?',//number seats
					'verbruik_gecombineerd' => round(4.9, 2),//fuel consumption combined
					'verbruik_stad'         => round(6.0, 2),//fuel consumption city
					'verbruik_snelweg'      => round(4.4, 2),//fuel consumption hightway
					'btw_verrekenbaar'      => '',//tax deductable
					'btw_percentage'        => 0,//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '177ps-frontantrieb-schwarz-2_DEU43231003415.htm',//weblink
					'uitrusting'            => [ //equipment/options
						'4-Wege-Lendenwirbelstütze',
						'Anhängevorrichtung',
						'Audi music interface',
						'Einparkhilfe plus',
						'Innenspiegel automatisch abblendend',
						'Komfortklimaautomatik 4-Zonen',
						'MMI® Navigation plus mit MMI touch®',
						'Sitzheizung vorn',
						'Xenon plus',
						'Ablagepaket',
						'Durchladeeinrichtung mit entnehmbarem Skisack',
						'DVD-/CD-Wechsler',
						'Innen- und Außenlichtpaket',
						'Kindersitzbefestigung ISOFIX für den Beifahrersitz',
						'Lederausstattung Milano',
						'Rücksitzlehne umklappbar',
						'Seitenairbags hinten',

												 'Außenfarbe Havannaschwarz',
		'Außenspiegel links, asphärisch','Außenspiegel mit integriertem LED-Blinklicht, elektrisch einstell- und beheizbar','Außenspiegel rechts, asphärisch', 'Außenspiegelgehäuse in Wagenfarbe lackiert','Entriegelung Heckklappe/Deckel hinten von innen (elektr.)','Glanzpaket', 'Stoßfänger verstärkt','Stufenheck', 'Zentralverriegelung mit Funkfernbedienung', 'ohne Dachreling'
					],
					'verkoper_adres'        => 'Lindenstraße 107 45894 Gelsenkirchen',//seller address
					'verkoper_telefoon'     => '(0209) 16229946',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => 'limousine',//body type
					'kleur_exterieur'       => 'havannaschwarz',//color exterior
					'kleur_interieur'       => 'schwarz-schwarz',//color interior
					'handler'               => 'Tiemeyer Gelsenkirchen-Buer GmbH & Co. KG',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [
						'//vtpimages.audi.com/carimg/3/1920/1440/1/34671827/12732046552.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/34671827/12732046229.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/34671827/12770456952.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/34671827/12770460239.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/34671827/12770461081.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/34671827/12770458090.jpg',
					],
				]
			],
			[
				$this->getUrlPrefix() . '286ps-allradantrieb-silber-2_DEU2185285215842NW.htm',
				[
					'parser'                => 'parser.audi.detail_page',
					'titel'                 => '', //title
					'merk'                  => '',//brand
					'model'                 => '',//model
					'external_id'           => '',//external ID
					'prijs'                 => '', //price of the car
					'brandstof'             => '',//fuel
					'bouwjaar'              => '',//build year
					'bouwjaar_maand'        => '',//build month
					'co2uitstoot'           => '',//co2-emission
					'variant'               => '',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => '',//transmission
					'kilometerstand'        => '',//milage
					'vermogen_pk'           => '',// Horse Power
					'vermogen_kw'           => '',
					'aantal_cilinders'      => '',//amount cilinders
					'cilinderinhoud'        => '',//cilinder capacity
					'aantal_deuren'         => 0,//total doors
					'aantal_zitplaatsen'    => 0,//number seats
					'verbruik_gecombineerd' => '',//fuel consumption combined
					'verbruik_stad'         => '',//fuel consumption city
					'verbruik_snelweg'      => '',//fuel consumption hightway
					'btw_verrekenbaar'      => '',//tax deductable
					'btw_percentage'        => '',//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '177ps-frontantrieb-schwarz-2_DEU43231003415.htm',//weblink
					'uitrusting'            => [ //equipment/options

					],
					'verkoper_adres'        => '',//seller address
					'verkoper_telefoon'     => '',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => '',//body type
					'kleur_exterieur'       => '',//color exterior
					'kleur_interieur'       => '',//color interior
					'handler'               => '',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [

					],
				]
			],
			[
				$this->getUrlPrefix() . '105ps-frontantrieb-grau-2_DEU232561984.htm',
				[
					'parser'                => 'parser.audi.detail_page',
					'titel'                 => '', //title
					'merk'                  => '',//brand
					'model'                 => '',//model
					'external_id'           => '',//external ID
					'prijs'                 => '', //price of the car
					'brandstof'             => '',//fuel
					'bouwjaar'              => '',//build year
					'bouwjaar_maand'        => '',//build month
					'co2uitstoot'           => '',//co2-emission
					'variant'               => '',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => '',//transmission
					'kilometerstand'        => '',//milage
					'vermogen_pk'           => '',// Horse Power
					'vermogen_kw'           => '',
					'aantal_cilinders'      => '',//amount cilinders
					'cilinderinhoud'        => '',//cilinder capacity
					'aantal_deuren'         => 0,//total doors
					'aantal_zitplaatsen'    => 0,//number seats
					'verbruik_gecombineerd' => '',//fuel consumption combined
					'verbruik_stad'         => '',//fuel consumption city
					'verbruik_snelweg'      => '',//fuel consumption hightway
					'btw_verrekenbaar'      => '',//tax deductable
					'btw_percentage'        => '',//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '177ps-frontantrieb-schwarz-2_DEU43231003415.htm',//weblink
					'uitrusting'            => [ //equipment/options

					],
					'verkoper_adres'        => '',//seller address
					'verkoper_telefoon'     => '',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => '',//body type
					'kleur_exterieur'       => '',//color exterior
					'kleur_interieur'       => '',//color interior
					'handler'               => '',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [

					],
				]
			],
		];
//		return $result;
		return [$result[0]];
	}

	protected function getUrlPrefix() {
		if (false) {
			return 'https://www.audi-boerse.de/gebrauchtwagen/';
		}
		else {
			return 'http://imo.vm/html/audi/';
		}
	}

}
