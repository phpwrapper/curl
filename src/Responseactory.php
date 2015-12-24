<?php

/**
 * Copyright © 2015 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace PhpWrapper\Curl;

class ResponseFactory
{

	/**
	 * @param Request $request
	 * @return Response
	 */
	public function create(Request $request)
	{
		return new Response($request);
	}

}
