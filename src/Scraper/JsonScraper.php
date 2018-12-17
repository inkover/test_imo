<?php
namespace Imod\Scraper;

trait JsonScraper {

	protected $jsonData;

	protected $content;

	protected function parse() {
		$this->jsonData = json_decode($this->content, true);
		$this->data = [];
		parent::parse();
	}
	public function getJsonData($path, $arr = null) {
		if (is_null($arr)) {
			$arr = $this->jsonData;
		}
		foreach (explode('.', $path) as $key) {
			if (!isset($arr[$key])) {
				return null;
			}
			$arr = $arr[$key];
		}
		return $arr;
	}

}