<?php

namespace Infrastructure\Api\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Class ApiController
 * @package Infrastructure\Api\Controllers
 */
class ApiController extends BaseController
{
	/**
	 * @var int
     */
	protected $statusCode = 200;
	/**
	 * @var Manager
     */
	protected $fractal;
	/**
	 * @var TransformerAbstract
     */
	protected $transformer;
	/**
	 * @var Request
     */
	protected $request;

	/**
	 *
     */
	public function __construct()
    {
		$this->request = Request::capture();
        $this->fractal = new Manager;
    }

	/**
	 * @return int
     */
	public function getStatusCode()
    {
    	return $this->statusCode;
    }

	/**
	 * @param $statusCode
	 * @return $this
     */
	public function setStatusCode($statusCode)
    {
    	$this->statusCode = $statusCode;
    	return $this;
    }

	/**
	 * @param $data
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respond($data, $headers=[])
    {
    	return response()->json($data, $this->getStatusCode(), $headers);
    }

	/**
	 * @param $data
	 * @param $headers
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respondWithPagination($paginator, $headers=[])
	{
		$data = $paginator->getCollection();
		$resource = new Collection($data, $this->transformer);
		$resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

		$data = $this->fractal->createData($resource)->toArray();
		return $this->respond($data);
	}

	/**
	 * @param $message
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}

	/**
	 * @param string $message
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respondNotFound($message = 'Not Found')
    {
    	return $this->setStatusCode(404)->respondWithError($message);
    }

	/**
	 * @param $data
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respondCreatedItem($data, $headers=[])
	{
		return $this->setStatusCode(201)->respondWithItem($data, $headers);
	}

	/**
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
     */
	public function respondDeleted($headers=[])
	{
		return $this->setStatusCode(204)->respond(null, $headers);
	}

    /*
	protected function getInclude()
	{
		$input = $this->request->input('include');
		return strlen(trim($input)) > 0 ? explode(',', $this->request->input('include')) : [];
	}
    */

	/**
	 * @param $data
	 * @return \Illuminate\Http\JsonResponse
     */
	protected function respondWithCollection($data, $headers=[])
	{
	    return $this->respond($this->getFractalData( new Collection($data, $this->transformer) ), $headers);
	}

	/**
	 * @param $data
	 * @return \Illuminate\Http\JsonResponse
     */
	protected function respondWithItem($data, $headers=[])
	{
      return $this->respond($this->getFractalData( new Item($data, $this->transformer) ), $headers);
	}

	protected function getCollection( $data, $name=null )
	{
			return $this->getFractalData($data);
	}

	/**
	 * @param $data
	 * @return array
     */
	protected function getFractalData($data)
	{
	    return $this->fractal->parseIncludes($this->request->input('includes', []))->createData($data)->toArray();
	}
}
