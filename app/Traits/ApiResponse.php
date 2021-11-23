<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponse
{
	/**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function success($data, string $message = null, int $code = 200)
	{
		return response()->json([
			'status' => 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  array|string|null  $data
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function error(string $message = null, $data = null, int $code = 422)
	{
		return response()->json([
			'status' => 'Error',
			'message' => $message,
			'errors' => $data
		], $code);
	}

}
