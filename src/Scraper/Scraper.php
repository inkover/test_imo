<?php
/**
 * Created by PhpStorm.
 * User: Remon Versteeg
 * Date: 14-12-2018
 * Time: 10:38
 */

namespace Imod\Scraper;

use GuzzleHttp\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;

abstract class Scraper {

	private $url;

	protected $content;

	protected $data;

	/** @var Crawler */
	protected $crawler;


	/** @var HttpClient */
	private $httpClient;

	abstract protected function getParserAlias();

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	public function scrape() {
		$this->download();
		$this->parse();
	}

	public function getData() {
		return $this->data;
	}

	protected function download() {
		$client        = $this->getHttpClient();
		$response      = $client->get($this->getUrl());
		$this->content = $response->getBody()->getContents();
	}

	protected function parse() {
		$this->crawler = new Crawler($this->content);
		$this->data = [];
	}

	/**
	 * @return HttpClient
	 */
	protected function getHttpClient() {
		if (is_null($this->httpClient)) {
			$this->initHttpClient();
		}
		return $this->httpClient;
	}

	protected function initHttpClient() {
		$this->httpClient = new HttpClient([
			'http_errors' => false,
			'curl'        => [
				CURLOPT_SSL_VERIFYPEER => false,
			],
			'headers'     => [
				'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537',

			]
		]);
		
	}

	protected function getFromCrawler(Crawler $crawler, $attr = null, $default = null) {
		if ($crawler->count() == 0) {
			return $default;
		}
		if ($attr) {
			$result = $crawler->attr($attr);
		}
		else {
			$result = $crawler->text();
		}
		if (empty($result)) {
			$result = $default;
		}
		return $result;
	}

	protected function pregMatch($preg, $string, $default = '', $matchId = 1) {
		if (empty($string)) {
			return $default;
		}
		if (!preg_match($preg, $string, $matches)) {
			return $default;
		}
		if (!isset($matches[$matchId])) {
			return $default;
		}
		return $matches[$matchId];
	}

}