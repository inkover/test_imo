<?php
/**
 * Created by PhpStorm.
 * User: user1624
 * Date: 15.12.2018
 * Time: 21:27
 */


class AudiListPageTest extends PHPUnit_Framework_TestCase {

	/** @var \Imod\Scraper\AudiBoerse\ListPage */
	protected $scraper;

	protected function setUp() {

		$this->scraper = new \Imod\Scraper\AudiBoerse\ListPage();

	}

	protected function tearDown() {
		$this->scraper = null;
	}


	/**
	 * @dataProvider getUrls
	 * @param $url
	 */
	public function testUrl($url) {
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\ListPage::class, $this->scraper->setUrl($url), 'Test URL set');
		$this->assertEquals($url, $this->scraper->getUrl(), 'Test URL set');
	}

	public function getUrls() {
		return [
			[null],
			['https://test']
		];
	}

	/**
	 * @dataProvider getListUrls
	 * @param $url
	 * @param $models
	 * @param $page
	 */
	public function testUrlGenerator($url, $models, $page) {
		$this->assertSame($url, \Imod\Scraper\AudiBoerse\ListPage::generateUrl($models, $page), 'Check URL is correct');
	}

	public function getListUrls() {
		return [
			[
				'https://www.audi-boerse.de/gebrauchtwagen/i/s|10,AACV,AAAO,AADK,AADL,AABW,AAEL,AACP,AACT,AADB,AADF,AAAU,AACM,AACX/l|24,1,STAT_GWPLUS,U/controller.htm?act=list&v=3&scrolling=1',
				explode(',', 'AACV,AAAO,AADK,AADL,AABW,AAEL,AACP,AACT,AADB,AADF,AAAU,AACM,AACX'),
				1
			]
		];
	}

	/**
	 * @dataProvider getScrapperData
	 * @param $models
	 * @param $page
	 * @param $urlPrefix
	 * @param $linksCount
	 * @param $nextUrlExists
	 */
	public function testScrapper($models, $page, $urlPrefix, $linksCount, $nextUrlExists) {
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\ListPage::class, $this->scraper->setModels($models), 'Test Models set');
		$this->assertInstanceOf(\Imod\Scraper\AudiBoerse\ListPage::class, $this->scraper->setPageNumber($page), 'Test page set');
		$this->assertSame(\Imod\Scraper\AudiBoerse\ListPage::generateUrl($models, $page), $this->scraper->getUrl(), 'Test URL is correct');
		$this->scraper->scrape();
		$parsedData = $this->scraper->getData();
		$this->assertTrue(is_array($parsedData), 'Test parsed data is array');
		$this->assertTrue(isset($parsedData['detail_urls']) && is_array($parsedData['detail_urls']), 'Test parsed URLs is array');
		$this->assertEquals($linksCount, count($parsedData['detail_urls']), 'Test parsed URLs count');

		if ($nextUrlExists) {
			$this->assertTrue(isset($parsedData['next_paginator_url']), 'Test next URL exists');
			$parsedNextUrl = $parsedData['next_paginator_url'];
			$this->assertSame(\Imod\Scraper\AudiBoerse\ListPage::generateUrl($models, $page + 1), $parsedNextUrl, 'Test next URL is correct');
		}
		else {
			$this->assertNull($parsedData['next_paginator_url'], 'Test next URL is null');
		}
		foreach ($parsedData['detail_urls'] as $detailUrl) {
			$this->assertTrue(strpos($detailUrl, $urlPrefix) !== false, 'Test detail URL is correct');
		}
	}


	public function getScrapperData() {
		$result = [
			[
				explode(',', 'AACV,AAAO,AADK,AADL,AABW,AAEL,AACP,AACT,AADB,AADF,AAAU,AACM,AACX'),
				1,
				'/audi/a',
				24,
				true
			],
			[
				['AAEL'],
				2,
				'/audi/a',
				9,
				false
			]
		];
		return $result;
	}

}
