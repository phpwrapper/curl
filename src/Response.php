<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class Response
{

	/** @var Request */
	private $request;

	/** @var resource */
	private $curl;

	/** @var string */
	private $curlResponse;

	/**
	 * @param Request $request
	 * @throws RequestFailureException
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;

		$this->initCurl();
		$this->checkErrors();
	}

	public function __destruct()
	{
		@curl_close($this->curl); // @ - intentionally (we're in destructor)
	}

	/**
	 * @return int
	 */
	public function getStatus()
	{
		return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		$headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
		return explode("\n", substr($this->curlResponse, 0, $headerSize));
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		$headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
		return substr($this->curlResponse, $headerSize);
	}

	private function initCurl()
	{
		$this->curl = curl_init($this->request->getUrl());

		foreach ($this->request->getOptions() as $option) {
			curl_setopt($this->curl, $option[0], $option[1]);
		}

		$this->curlResponse = curl_exec($this->curl);
	}

	private function checkErrors()
	{
		$error = curl_error($this->curl);

		if ($error) {
			throw new RequestFailureException($error);
		}
	}

}
