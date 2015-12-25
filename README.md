[![Build Status](https://img.shields.io/shippable/567c2f691895ca447466e810.svg)](https://app.shippable.com/projects/567c2f691895ca447466e810)

# PhpWrapper\Curl

Simple cURL wrapper.

## Installation

```bash
$ composer require phpwrapper/curl dev-master
```


## Usage

```php
<?php

use PhpWrapper\Curl;


// Init factory with default options
$curlFactory = new Curl\CurlFactory([
	[CURLOPT_SSL_VERIFYPEER, TRUE],
	[CURLOPT_SSL_VERIFYHOST, TRUE],
]);


// Create and setup cURL
$curl = $curlFactory->create('https://api.example.com/v1');
$curl->addHeader('Accept: application/json');
$curl->addParameter('myKey', 'myValue');

/** @var Curl\Response $response */
$response = $curl->get();

// or
$response = $curl->post();

// or
$response = $curl->put();

// or
$response = $curl->delete();


// Process response
var_dump($response->getStatus());
var_dump($response->getHeaders());
var_dump($response->getBody());

```
