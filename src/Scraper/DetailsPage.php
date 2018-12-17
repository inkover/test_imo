<?php
/**
 * Created by PhpStorm.
 * User: Inkover
 * Date: 15.12.2018
 * Time: 17:57
 */

namespace Imod\Scraper;


abstract class DetailsPage extends Scraper {

	abstract protected function parseEditDate();
	abstract protected function parseTitle();
	abstract protected function parseBrand();
	abstract protected function parseModel();
	abstract protected function parseExternalId();
	abstract protected function parsePrice();
	abstract protected function parseImages();
	abstract protected function parseBuildDate($format);
	abstract protected function parseTaxDeductible();
	abstract protected function parseTaxPercentage();
	abstract protected function parseFuel();
	abstract protected function parseCo2Emissions();
	abstract protected function parseVariant();
	abstract protected function parseTransmission();
	abstract protected function parseMillage();
	abstract protected function parseHorsePower();
	abstract protected function parseKwPower();
	abstract protected function parseCylindersAmount();
	abstract protected function parseCylindersCapacity();
	abstract protected function parseDoorsNumber();
	abstract protected function parseSeatsNumber();
	abstract protected function parseFuelConsumptionCombined();
	abstract protected function parseFuelConsumptionCity();
	abstract protected function parseFuelConsumptionHighway();
	abstract protected function parseOptions();
	abstract protected function parseBodyType();
	abstract protected function parseExteriorColor();
	abstract protected function parseInteriorColor();
	abstract protected function parseSellerAddress();
	abstract protected function parseSellerPhone();
	abstract protected function parseSellerName();
	abstract protected function parseCoating();
	abstract protected function parseToken();

	protected function parse() {

		$this->data = [];

		//Common data
		$this->data['parser']                = $this->getParserAlias();
		$this->data['weblink_advertentie']   = $this->getUrl(); //weblink
		$this->data['editted_at']            = $this->parseEditDate(); //edited
		$this->data['images']				 = $this->parseImages();


		$this->data['titel']                 = $this->parseTitle(); //title
		$this->data['merk']                  = $this->parseBrand(); //brand
		$this->data['model']                 = $this->parseModel(); //model
		$this->data['external_id']           = $this->parseExternalId(); //external ID
		$this->data['prijs']                 = $this->parsePrice(); //price of the car
		$this->data['bouwjaar']              = $this->parseBuildDate('Y'); //build year
		$this->data['bouwjaar_maand']        = $this->parseBuildDate('m'); //build month

		$this->data['btw_verrekenbaar']      = $this->parseTaxDeductible(); //tax deductible
		$this->data['btw_percentage']        = $this->parseTaxPercentage(); //tax percentage


		// Tech specs
		$this->data['brandstof']             = $this->parseFuel(); //fuel
		$this->data['co2uitstoot']           = $this->parseCo2Emissions(); //co2-emission
		$this->data['versnellingsbak']       = $this->parseTransmission(); //transmission
		$this->data['kilometerstand']        = $this->parseMillage(); //millage
		$this->data['vermogen_pk']           = $this->parseHorsePower(); // Horse Power
		$this->data['vermogen_kw']           = $this->parseKwPower();
		$this->data['aantal_cilinders']      = $this->parseCylindersAmount(); //amount cylinders
		$this->data['cilinderinhoud']        = $this->parseCylindersCapacity(); //cylinder capacity
		$this->data['aantal_deuren']         = $this->parseDoorsNumber(); //total doors
		$this->data['aantal_zitplaatsen']    = $this->parseSeatsNumber(); //number seats
		$this->data['verbruik_gecombineerd'] = $this->parseFuelConsumptionCombined(); //fuel consumption combined
		$this->data['verbruik_stad']         = $this->parseFuelConsumptionCity(); //fuel consumption city
		$this->data['verbruik_snelweg']      = $this->parseFuelConsumptionHighway(); //fuel consumption highway
		$this->data['uitrusting']            = $this->parseOptions(); //equipment/options
		$this->data['carrosserie']           = $this->parseBodyType(); //body type
		$this->data['kleur_exterieur']       = $this->parseExteriorColor(); //color exterior
		$this->data['kleur_interieur']       = $this->parseInteriorColor(); //color interior
		$this->data['variant']               = $this->parseVariant(); //variant-> like Avant|GTI etc.


		//Seller
		$this->data['verkoper_adres']        = $this->parseSellerAddress(); //seller address
		$this->data['verkoper_telefoon']     = $this->parseSellerPhone(); //seller phone
		$this->data['handler']               = $this->parseSellerName(); //handler/seller
		$this->data['bekleding']             = $this->parseCoating(); //coating ???
		$this->data['token']                 = $this->parseToken(); //unique car token (for exmaple id) ???

	}

}