<?php
/**
 * Created by PhpStorm.
 * User: Remon Versteeg
 * Date: 14-12-2018
 * Time: 10:35
 */


namespace Imod\Scraper;

use Symfony\Component\DomCrawler\Crawler;

class Audi extends AbstractScraper
{


    /**
     *
     */
    public function getPages(){




    }

    /**
     * @param $url
     * @return array
     */
    public function getDetails( $url ){




        $response = $this->getContent()->get($url);

        $crawler = new Crawler($response->getBody()->getContents());




        $values = [
            'parser'                => 'parser.audi.detail_page',
            'titel'                 => '', //title
            'merk'                  => '',//brand
            'model'                 => '',//model
            'external_id'           => '',//external ID
            'prijs'                 => $this->getPrice($crawler), //price of the car
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
            'weblink_advertentie'   => $url,//weblink
            'uitrusting'            => '',//equipment/options
            'verkoper_adres'        => '',//seller address
            'verkoper_telefoon'     => '',//seller phone
            'editted_at'            => '',//edited
            'carrosserie'           => '',//body type
            'kleur_exterieur'       => '',//color exterior
            'kleur_interieur'       => '',//color interior
            'handler'               => '',//handler/seller
            'bekleding'             => '',//coating
            'token'                 => '',//unique car token (for exmaple id)
        ];




        return $values;

    }


    /**
     * @param Crawler $crawler
     * @return null|string
     */
    public function getPrice(Crawler $crawler){

        if($crawler->filter('meta[itemprop=price]')->count()){
            return $crawler->filter('meta[itemprop=price]')->attr('content');
        }


    }


}