<?php


namespace Imod\Scraper\AudiBoerse;

use Symfony\Component\DomCrawler\Crawler;

class ListPage extends \Imod\Scraper\ListPage {

	const PER_PAGE = 24;

	const URL_TEMPLATE = 'https://www.audi-boerse.de/gebrauchtwagen/i/s|10,%s/l|%d,%d,STAT_GWPLUS,U/controller.htm?act=list&v=3&scrolling=1';

	protected $models = [];

	protected $pageNumber = 1;


	public static function generateUrl(array $models, $page = 1, $perPage = self::PER_PAGE) {
		return sprintf(self::URL_TEMPLATE, implode(',', $models), $perPage, $page);
	}

	public function getModels() {
		return $this->models;
	}

	public function setModels(array $models) {
		$this->models = $models;
		$this->updateUrl();
		return $this;
	}

	public function getPageNumber() {
		return $this->pageNumber;
	}

	public function setPageNumber($page) {
		$this->pageNumber = $page;
		$this->updateUrl();
		return $this;
	}

	private function updateUrl() {
		$this->setUrl(self::generateUrl($this->models, $this->pageNumber));
	}


	protected function getParserAlias() {
		return 'parser.audi.list_page';
	}

	protected function parseDetailPages() {
		$result = [];
		$this->crawler->filter('article.car-teaser div.details a.title-link')->each(function (Crawler $a) use (&$result) {
			$result[] = $a->attr('href');
		});
		return $this->detailUrls = $result;
	}

	protected function setNextPageUrl() {
		if (count($this->detailUrls) < self::PER_PAGE) {
			return null;
		}
		return $this->nextPaginatorUrl = self::generateUrl($this->getModels(), $this->getPageNumber() + 1);
	}


}