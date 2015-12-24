<?php

namespace PhpWrapper\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{

	public function testResponse()
	{
		$url = 'foo-bar';
		$options = [
			[CURLOPT_RETURNTRANSFER, TRUE],
			[CURLOPT_HEADER, TRUE],
		];

		$request = $this->getMockWithoutInvokingTheOriginalConstructor(Request::class);
		$response = $this->getMockWithoutInvokingTheOriginalConstructor(Response::class);

		$requestFactory = $this->getRequestFactory();
		$requestFactory
			->expects($this->once())
			->method('create')
			->with($url, $options)
			->willReturn($request);

		$responseFactory = $this->getResponseFactory();
		$responseFactory
			->expects($this->once())
			->method('create')
			->with($request)
			->willReturn($response);

		$curl = new Curl($url);
		$curl->setRequestFactory($requestFactory);
		$curl->setResponseFactory($responseFactory);

		$this->assertSame($response, $curl->get());
	}

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|RequestFactory
	 */
	private function getRequestFactory()
	{
		return $this->getMock(RequestFactory::class, ['create']);
	}

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|ResponseFactory
	 */
	private function getResponseFactory()
	{
		return $this->getMock(ResponseFactory::class, ['create']);
	}

}
