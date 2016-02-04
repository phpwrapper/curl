<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class Curl
{

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	const CURLOPT_JSON = 'curl.json';

	/** @var string */
	private $url;

	/** @var RequestFactory */
	private $requestFactory;

	/** @var ResponseFactory */
	private $responseFactory;

	/** @var string */
	private $method;

	/** @var array */
	private $headers = [];

	/** @var array */
	private $parameters = [];

	/** @var array */
	private $options = [
		[CURLOPT_RETURNTRANSFER, TRUE],
		[CURLOPT_HEADER, TRUE],
	];

	public function __construct($url)
	{
		$this->url = $url;
		$this->requestFactory = new RequestFactory();
		$this->responseFactory = new ResponseFactory();
	}

	/**
	 * @param RequestFactory $requestFactory
	 * @return $this
	 */
	public function setRequestFactory(RequestFactory $requestFactory)
	{
		$this->requestFactory = $requestFactory;
		return $this;
	}

	/**
	 * @param ResponseFactory $responseFactory
	 * @return $this
	 */
	public function setResponseFactory(ResponseFactory $responseFactory)
	{
		$this->responseFactory = $responseFactory;
		return $this;
	}

	/**
	 * @param boolean $isJson
	 * @return $this
	 */
	public function setIsJson($isJson)
	{
		$this->options[self::CURLOPT_JSON] = (bool)$isJson;
		return $this;
	}

	/**
	 * @param string $header
	 * @return $this
	 */
	public function addHeader($header)
	{
		$this->headers[] = $header;
		return $this;
	}

	/**
	 * @param mixed $name
	 * @param mixed $value
	 * @return $this
	 */
	public function addParameter($name, $value)
	{
		$this->parameters[$name] = $value;
		return $this;
	}

	/**
	 * @param int $option CURLOPT_* constant.
	 * @param mixed $value
	 * @return $this
	 */
	public function addOption($option, $value)
	{
		$this->options[] = [$option, $value];
		return $this;
	}

	/**
	 * @return Response
	 * @throws RequestFailureException
	 */
	public function get()
	{
		$this->method = self::METHOD_GET;
		return $this->exec();
	}

	/**
	 * @return Response
	 * @throws RequestFailureException
	 */
	public function post()
	{
		$this->method = self::METHOD_POST;
		return $this->exec();
	}

	/**
	 * @return Response
	 * @throws RequestFailureException
	 */
	public function put()
	{
		$this->method = self::METHOD_PUT;
		return $this->exec();
	}

	/**
	 * @return Response
	 * @throws RequestFailureException
	 */
	public function delete()
	{
		$this->method = self::METHOD_DELETE;
		return $this->exec();
	}

	/**
	 * @return Response
	 */
	private function exec()
	{
		$url = $this->url;
		$options = $this->options;

		switch ($this->method) {
			case self::METHOD_GET:
				break;

			case self::METHOD_POST:
				$options[] = [CURLOPT_POST, TRUE];
				break;

			default:
				$options[] = [CURLOPT_CUSTOMREQUEST, $this->method];
		}

		if ($this->parameters) {
			if ($this->method === self::METHOD_GET) {
				$url .= '?' . http_build_query($this->parameters);
			} else {
				$isJson = isset($options[self::CURLOPT_JSON]) && $options[self::CURLOPT_JSON];

				$data = ($isJson) ?
					json_encode($this->parameters) :
					http_build_query($this->parameters);

				$options[] = [CURLOPT_POSTFIELDS, $data];
			}
		}

		if ($this->headers) {
			$options[] = [CURLOPT_HTTPHEADER, $this->headers];
		}

		$request = $this->requestFactory->create($url, $options);
		return $this->responseFactory->create($request);
	}

}
