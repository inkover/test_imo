<?php
/**
 * Created by PhpStorm.
 * User: Inkover
 * Date: 15.12.2018
 * Time: 17:56
 */

namespace Imod\Scraper;


abstract class ListPage extends Scraper {

	protected $detailUrls;

	protected $nextPaginatorUrl;

	abstract protected function parseDetailPages();

	abstract protected function setNextPageUrl();

	protected function parse() {
		parent::parse();

		$this->data = [
			'parser' => $this->getParserAlias(),
			'detail_urls' => $this->parseDetailPages(),
			'next_paginator_url' => $this->setNextPageUrl()
		];
	}

}