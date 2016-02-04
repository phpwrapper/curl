<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class RequestFactory
{

	/**
	 * @param string $url
	 * @param array $options
	 * @param bool $isJson
	 * @return Request
	 */
	public function create($url, array $options, $isJson = FALSE)
	{
		return new Request($url, $options, $isJson);
	}

}
