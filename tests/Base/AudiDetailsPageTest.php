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
					'aantal_deuren'         => '',//total doors
					'aantal_zitplaatsen'    => '',//number seats
					'verbruik_gecombineerd' => round(4.9, 2),//fuel consumption combined
					'verbruik_stad'         => round(6.0, 2),//fuel consumption city
					'verbruik_snelweg'      => round(4.4, 2),//fuel consumption hightway
					'btw_verrekenbaar'      => 0,//tax deductable
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
						 'Außenspiegel links, asphärisch',
						 'Außenspiegel mit integriertem LED-Blinklicht, elektrisch einstell- und beheizbar',
						 'Außenspiegel rechts, asphärisch',
						 'Außenspiegelgehäuse in Wagenfarbe lackiert',
						 'Entriegelung Heckklappe/Deckel hinten von innen (elektr.)',
						 'Glanzpaket',
						 'Stoßfänger verstärkt',
						 'Stufenheck',
						 'Zentralverriegelung mit Funkfernbedienung',
						 'ohne Dachreling',
						 'Aluminium-Gussräder im 7-Arm-Design, Größe 7,5 J x 16, mit Reifen 225/60 R 16',
						 'Reifen 225/60 R 16',
						 'Reifendruck-Kontrollanzeige',
						 'Reifenreparaturset',
						 'Armaturentafel schwarz-schwarz',
						 'Teppich schwarz',
						 'Himmel  mondsilber',
						 'Dachhimmel in Stoff',
						 'Einstiegsleisten mit Aluminiumeinlagen',
						 'Scheiben seitlich und hinten in Wärmeschutzverglasung',
						 'Wärmeschutzverglasung, grün getönt',
						 'Zigarettenanzünder und Aschenbecher',
						 'automatische Umluftregelung',
						 'Lenkradeinstellung, axial und vertikal',
						 'Multifunktions-Lederlenkrad im 4-Speichen-Design',
						 'Lederausstattung Milano schwarz-schwarz',
						 'Höheneinstellung für Vordersitze, manuell',
						 'zentrale Bedieneinheit, vorn',
						 '4 Zyl.Dieselmotor 2,0L Aggr. 03L.M',
						 '4-Zyl.Turbodieselmotor 2,0 L/130 KW(4V) TDI Common-Rail Grundmotor: TR1,TD1,TM4/TL4/TP4',
						 '6-Gang-Schaltgetriebe',
						 'Abgaskonzept, EU5',
						 'Kraftstoffbehälter',
						 'Kraftstoffsystem Diesel',
						 'Start-Stop-System mit Rekuperation',
						 'Vorderradantrieb',
						 'Anfahrassistent',
						 'Audi pre sense basic',
						 'Dynamikfahrwerk',
						 'Elektromechanische Servolenkung',
						 'Elektronisches Stabilisierungsprogramm ESP',
						 'Geschwindigkeitsregelanlage',
						 'Kindersitzbefestigung ISOFIX für die äußeren Fondsitze',
						 'Licht-/Regensensor',
						 'Ohne Kamerasysteme/Umfeldsensorik',
						 'Ohne Nachtsichtsystem',
						 'Scheibenbremsen vorn',
						 'Tagfahrlicht',
						 'Wegfahrsperre elektronisch',
						 'Audi drive select',
						 'Linkslenker',

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
						'//vtpimages.audi.com/carimg/3/1920/1440/7/34671827/12770458563.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/34671827/12770458321.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/34671827/12770460117.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/34671827/12770458193.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/34671827/12770461101.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/34671827/12770462505.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/1/34671827/12732046552.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/34671827/12732046229.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/34671827/12770456952.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/34671827/12770460239.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/34671827/12770461081.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/34671827/12770458090.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/7/34671827/12770458563.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/34671827/12770458321.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/34671827/12770460117.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/34671827/12770458193.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/34671827/12770461101.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/34671827/12770462505.jpg',
					],
				]
			],
			[
				$this->getUrlPrefix() . '286ps-allradantrieb-silber-2_DEU2185285215842NW.htm',
				'Q8',
				'SUV',
				[
					'parser'                => 'parser.audi.detail_page',
					'titel'                 => 'Audi Q8', //title
					'merk'                  => 'Audi',//brand
					'model'                 => 'Q8',//model
					'external_id'           => 'DEU2185285215842NW',//external ID
					'prijs'                 => 84990, //price of the car
					'brandstof'             => 'diesel',//fuel
					'bouwjaar'              => 2018,//build year
					'bouwjaar_maand'        => 10,//build month
					'co2uitstoot'           => 0,//co2-emission
					'variant'               => '',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => 'automatik',//transmission
					'kilometerstand'        => 3580,//milage
					'vermogen_pk'           => 286,// Horse Power
					'vermogen_kw'           => 210,
					'aantal_cilinders'      => '',//amount cilinders
					'cilinderinhoud'        => 2967,//cilinder capacity
					'aantal_deuren'         => '',//total doors
					'aantal_zitplaatsen'    => '',//number seats
					'verbruik_gecombineerd' => 6.6,//fuel consumption combined
					'verbruik_stad'         => 0.0,//fuel consumption city
					'verbruik_snelweg'      => 0.0,//fuel consumption hightway
					'btw_verrekenbaar'      => 543,//tax deductable
					'btw_percentage'        => 1.0,//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '286ps-allradantrieb-silber-2_DEU2185285215842NW.htm',//weblink
					'uitrusting'            => [ //equipment/options

					],
					'verkoper_adres'        => 'Uellendahler Straße 306 42109 Wuppertal',//seller address
					'verkoper_telefoon'     => '+49 202 266310',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => 'suv',//body type
					'kleur_exterieur'       => 'florettsilber',//color exterior
					'kleur_interieur'       => '',//color interior
					'handler'               => 'Audi Zentrum Wuppertal Automobilvertriebgesellschaft Wuppertal GmbH & Co. KG',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [
						'//vtpimages.audi.com/carimg/3/1920/1440/1/34550673/12564294809.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/34550673/12596962817.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/34550673/12596962767.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/34550673/12596962766.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/34550673/12596962721.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/34550673/12596962760.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/7/34550673/12596962476.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/34550673/12596962510.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/34550673/12596962820.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/34550673/12596962723.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/34550673/12596962819.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/34550673/12596962702.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/13/34550673/12596962847.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/14/34550673/12596962707.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/15/34550673/12596962679.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/1/34550673/12564294809.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/34550673/12596962817.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/34550673/12596962767.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/34550673/12596962766.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/34550673/12596962721.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/34550673/12596962760.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/7/34550673/12596962476.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/34550673/12596962510.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/34550673/12596962820.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/34550673/12596962723.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/34550673/12596962819.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/34550673/12596962702.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/13/34550673/12596962847.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/14/34550673/12596962707.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/15/34550673/12596962679.jpg',
					],
				]
			],
			[
				$this->getUrlPrefix() . '105ps-frontantrieb-grau-2_DEU232561984.htm',
				'A3',
				'Sportback',
				[
					'parser'                => 'parser.audi.detail_page',
					'titel'                 => 'Audi A3 Sportback', //title
					'merk'                  => 'Audi',//brand
					'model'                 => 'A3',//model
					'external_id'           => 'DEU232561984',//external ID
					'prijs'                 => 10280, //price of the car
					'brandstof'             => 'diesel',//fuel
					'bouwjaar'              => 2012,//build year
					'bouwjaar_maand'        => 11,//build month
					'co2uitstoot'           => 112,//co2-emission
					'variant'               => '',//variant-> like Avant|GTI etc. ??
					'versnellingsbak'       => 'handschaltung',//transmission
					'kilometerstand'        => 76600,//milage
					'vermogen_pk'           => 105,// Horse Power
					'vermogen_kw'           => 77,
					'aantal_cilinders'      => '',//amount cilinders
					'cilinderinhoud'        => 1598,//cilinder capacity
					'aantal_deuren'         => '',//total doors
					'aantal_zitplaatsen'    => '',//number seats
					'verbruik_gecombineerd' => 4.2,//fuel consumption combined
					'verbruik_stad'         => 5.1,//fuel consumption city
					'verbruik_snelweg'      => 3.8,//fuel consumption hightway
					'btw_verrekenbaar'      => 0,//tax deductable
					'btw_percentage'        => 0,//tax percentage
					'weblink_advertentie'   => $this->getUrlPrefix() . '105ps-frontantrieb-grau-2_DEU232561984.htm',//weblink
					'uitrusting'            => [ //equipment/options
						 'Ablagepaket',
						'Aluminium-Gussräder im 6-Speichen-Design, Größe 6,5 J x 16 mit Reifen 205/55 R 16',
						'Beifahrersitz höheneinstellbar',
						'Dachreling in Aluminium eloxiert',
						'Lichtpaket',
						'Mittelarmlehne vorn',
						'Navigationssystem mit MMI®-Bedienlogik',
						'Nebelscheinwerfer',
						'USB-Vorbereitung Audi exclusive',
						'USB-Vorbereitung Audi exclusive',
						'Zigarettenanzünder und Aschenbecher',
						'Kindersitzbefestigung ISOFIX',
						'All-Season-Reifen 205/55 R 16',
						'Komfortpaket plus',
						'Außenfarbe Dakotagrau',
						'5 Türen',
						'Außenspiegel elektrisch einstellbar, Gehäuse in Wagenfarbe lackiert, Spiegelglas links asphärisch, rechts konvex',
						'Außenspiegel links, asphärisch',
						'Außenspiegel rechts (großes Sichtfeld), konvex',
						'Funkfernbedienung',
						'Halogenscheinwerfer in Freiformtechnik mit Klarglasabdeckung',
						'Heckscheibenwischer',
						'Radschrauben Standard',
						'Scheibenwaschdüsen beheizbar, vorn',
						'Schutzleisten',
						'Sportback',
						'Reifenreparaturset',
						'Armaturentafel schwarz-schwarz',
						'Teppich schwarz',
						'Himmel silber',
						'Dekoreinlagen Perlglanz',
						'Fensterheber vorn und hinten elektrisch',
						'Formhimmel Standard',
						'Innenspiegel, abblendbar',
						'Ohne Trennwand',
						'Scheiben seitlich und hinten in Wärmeschutzverglasung',
						'Wärmeschutzverglasung',
						'Sitzbezüge in Stoff Frequenz schwarz',
						'3 Kopfstützen hinten',
						'Normalsitz vorn rechts',
						'Normalsitze vorn',
						'Rücksitzlehne, umklappbar',
						'Sitzbezüge in Stoff Frequenz',
						'Navigations CD (Deutschland)',
						'4 Zyl.Dieselmotor 1,6L Aggr. 03L.1',
						'4-Zyl.Turbodieselmotor 1,6 L/77 KW(4V) TDI Common-Rail Grundmotor ist: TF3/TN1/TJ1',
						'5-Gang-Schaltgetriebe',
						'Abgaskonzept, EU5',
						'Kraftstoffsystem Diesel',
						'Start-Stop-System',
						'Vorderradantrieb',
						'Dreipunkt-Automatikgurt für mittleren Fondsitz',
						'ESC mit elektronischer Quersperre',
						'Kopfairbagsystem',
						'Leuchtweitenregulierung',
						'Nebelschlussleuchten',
						'Scheibenwaschanlage',
						'Sicherheitskopfstützen',
						'Tagfahrlicht',
						'Waschwasserstandsanzeige',
						'Wegfahrsperre, elektronisch',
						'elektromechanische Servolenkung',
						'elektronische Stabilisierungskontrolle (ESC)',
						'Ausstattung Attraction',
						'Linkslenker',
						'Normalausführung'
					],
					'verkoper_adres'        => 'Am Wörtzgarten 20 65510 Idstein',//seller address
					'verkoper_telefoon'     => '(06126) 2277-19',//seller phone
					'editted_at'            => '',//edited
					'carrosserie'           => 'sportback',//body type
					'kleur_exterieur'       => 'dakotagrau',//color exterior
					'kleur_interieur'       => 'schwarz',//color interior
					'handler'               => 'AUTOSCHMITT IDSTEIN GmbH',//handler/seller
					'bekleding'             => '',//coating
					'token'                 => '',//unique car token (for exmaple id)
					'images'                => [
						'//vtpimages.audi.com/carimg/3/1920/1440/1/33977675/12656554812.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/33977675/12656562438.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/33977675/12656557658.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/33977675/12656557662.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/33977675/12656566382.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/33977675/12656565694.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/7/33977675/12656565109.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/33977675/12656565901.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/33977675/12656547345.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/33977675/12656562263.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/33977675/12656547224.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/33977675/12656547349.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/13/33977675/12656565904.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/14/33977675/12656561856.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/15/33977675/12656567151.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/16/33977675/12656562273.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/1/33977675/12656554812.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/2/33977675/12656562438.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/3/33977675/12656557658.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/4/33977675/12656557662.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/5/33977675/12656566382.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/6/33977675/12656565694.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/7/33977675/12656565109.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/8/33977675/12656565901.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/9/33977675/12656547345.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/10/33977675/12656562263.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/11/33977675/12656547224.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/12/33977675/12656547349.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/13/33977675/12656565904.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/14/33977675/12656561856.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/15/33977675/12656567151.jpg',
						'//vtpimages.audi.com/carimg/3/1920/1440/16/33977675/12656562273.jpg',

					],
				]
			],
		];
		return $result;
	}

	protected function getUrlPrefix() {
		if (true) {
			return 'https://www.audi-boerse.de/gebrauchtwagen/';
		}
		else {
			return 'http://imod.vm/html/audi/detail/';
		}
	}

}
