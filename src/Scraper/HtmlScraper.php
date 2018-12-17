<?php
/**
 * Created by PhpStorm.
 * User: user1624
 * Date: 17.12.2018
 * Time: 14:52
 */

namespace Imod\Scraper;


use Symfony\Component\DomCrawler\Crawler;

trait HtmlScraper {

	/** @var Crawler */
	protected $crawler;

	protected function parse() {
		$this->crawler = new Crawler($this->content);
		$this->data = [];
		parent::parse();
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
		return trim($result);
	}

}