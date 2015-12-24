<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class Request
{

	/** @var string */
	private $url;

	/** @var array */
	private $options;

	/**
	 * @param string $url
	 * @param array $options
	 */
	public function __construct($url, array $options)
	{
		$this->url = $url;
		$this->options = $options;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

}
