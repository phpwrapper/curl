<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class CurlFactory
{

	/** @var array */
	private $options = [];

	/**
	 * @param array $options CURLOPT_* rules.
	 */
	public function __construct(array $options = [])
	{
		$this->options = $options;
	}

	/**
	 * @param string $url
	 * @return Curl
	 */
	public function create($url)
	{
		$curl = new Curl($url);

		foreach ($this->options as $option) {
			$curl->addOption($option[0], $option[1]);
		}

		return $curl;
	}

}
