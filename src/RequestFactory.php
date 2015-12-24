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
	 * @return Request
	 */
	public function create($url, array $options)
	{
		return new Request($url, $options);
	}

}
