<?php
/**
 * Created by PhpStorm.
 * User: Remon Versteeg
 * Date: 11-9-2018
 * Time: 20:21
 */




require_once __DIR__ . "/autoloader.php";


$url = 'https://www.audi-boerse.de/gebrauchtwagen/audi/q8/q8/wuppertal/diesel/automatik/286ps-allradantrieb-silber-2_DEU2185285215842NW.htm#/i/s|10,AAEO/l|12,1,STAT_GWPLUS,U';


$scraper = new \Imod\Scraper\AudiBoerse\DetailsPage();
$scraper->setBodyType('SUV');
$scraper->setModelName('S8');
$scraper->setUrl($url);
$scraper->scrape();
var_dump($scraper->getData());