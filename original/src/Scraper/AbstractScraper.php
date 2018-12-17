<?php
/**
 * Created by PhpStorm.
 * User: Remon Versteeg
 * Date: 14-12-2018
 * Time: 10:38
 */

namespace Imod\Scraper;

abstract class AbstractScraper{


    public function getContent(){


        return new \GuzzleHttp\Client(
            ['http_errors' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER  => false,
                ],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537',

                ]
            ]
        );



    }

}