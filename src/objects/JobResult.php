<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:24
 */

namespace mcorten87\rabbitmq_api\objects;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * A wrapper for \GuzzleHttp\Psr7\Response
 *
 * Class JobResult
 * @package mcorten87\rabbitmq_api\objects
 */
class JobResult
{
    private $response;

    public static function populateFromClientException(ClientException $e)
    {
        $body = $e->getResponse()->getBody();
        $data = json_decode($body);

        // find out what kind of error happend and give some extra help
        if (strpos($data->reason, 'inequivalent arg \'durable\'') !== false) {
            $data->cause = 'Queue already exists with different durable stat, delete the queue first';
        }

        $res = new Response($e->getCode(), $e->getResponse()->getHeaders(), json_encode($data));
        return new JobResult($res);
    }

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getBody()
    {
        $bodyContent = $this->response->getBody()->getContents();
        if (!empty($bodyContent)) {
            return json_decode($bodyContent);
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function isSuccess()
    {
        return $this->response->getStatusCode() === 200
            || $this->response->getStatusCode() === 201
            || $this->response->getStatusCode() === 204;
    }
}
