<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:24
 */

namespace mcorten87\rabbitmq_api\objects;

use \GuzzleHttp\Psr7\Response;

/**
 * A wrapper for \GuzzleHttp\Psr7\Response
 *
 * Class JobResult
 * @package mcorten87\rabbitmq_api\objects
 */
class JobResult
{
    private $response;

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getBody() {
        return $this->response->getBody()->getContents();
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->response->getStatusCode() === 200;
    }
}
