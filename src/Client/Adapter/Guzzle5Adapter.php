<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Client\Adapter;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sphere\Core\Error\SphereException;

class Guzzle5Adapter implements AdapterInterface
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct($options)
    {
        if (isset($options['base_uri'])) {
            $options['base_url'] = $options['base_uri'];
            unset($options['base_uri']);
        }
        $this->client = new Client($options);
    }

    /**
     * @internal
     * @return \GuzzleHttp\Event\Emitter|\GuzzleHttp\Event\EmitterInterface
     */
    public function getEmitter()
    {
        return $this->client->getEmitter();
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Sphere\Core\Error\SphereException
     * @throws \Sphere\Core\Error\BadGatewayException
     * @throws \Sphere\Core\Error\ConcurrentModificationException
     * @throws \Sphere\Core\Error\ErrorResponseException
     * @throws \Sphere\Core\Error\GatewayTimeoutException
     * @throws \Sphere\Core\Error\InternalServerErrorException
     * @throws \Sphere\Core\Error\InvalidTokenException
     * @throws \Sphere\Core\Error\NotFoundException
     * @throws \Sphere\Core\Error\ServiceUnavailableException
     */
    public function execute(RequestInterface $request)
    {
        $options = [
            'allow_redirects' => false,
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 10,
            'headers' => $request->getHeaders(),
            'body' => (string)$request->getBody()
        ];

        try {
            $guzzleRequest = $this->client->createRequest($request->getMethod(), (string)$request->getUri(), $options);
            $guzzleResponse = $this->client->send($guzzleRequest);
            $response = $this->packResponse($guzzleResponse);
        } catch (RequestException $exception) {
            $response = $this->packResponse($exception->getResponse());
            throw SphereException::create($request, $response, $exception);
        }

        return $response;
    }

    protected function packResponse(\GuzzleHttp\Message\ResponseInterface $response = null)
    {
        if (!$response instanceof \GuzzleHttp\Message\ResponseInterface) {
            return null;
        }
        return new Response(
            $response->getStatusCode(),
            $response->getHeaders(),
            (string)$response->getBody()
        );
    }

    /**
     * @param RequestInterface[] $requests
     * @return \Psr\Http\Message\ResponseInterface[]
     * @throws \Sphere\Core\Error\SphereException
     * @throws \Sphere\Core\Error\BadGatewayException
     * @throws \Sphere\Core\Error\ConcurrentModificationException
     * @throws \Sphere\Core\Error\ErrorResponseException
     * @throws \Sphere\Core\Error\GatewayTimeoutException
     * @throws \Sphere\Core\Error\InternalServerErrorException
     * @throws \Sphere\Core\Error\InvalidTokenException
     * @throws \Sphere\Core\Error\NotFoundException
     * @throws \Sphere\Core\Error\ServiceUnavailableException
     */
    public function executeBatch(array $requests)
    {
        $options = [
            'allow_redirects' => false,
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 10,
            'pool_size' => 25
        ];

        $results = Pool::batch(
            $this->client,
            $this->getBatchHttpRequests($requests),
            $options
        );

        $responses = [];
        foreach ($results as $key => $result) {
            if (!$result instanceof RequestException) {
                $response = $this->packResponse($result);
            } else {
                $httpResponse = $this->packResponse($result->getResponse());
                $request = $requests[$key];
                $response = SphereException::create($request, $httpResponse, $result);
            }
            $responses[$key] = $response;
        }

        return $responses;
    }

    /**
     * @return array
     */
    protected function getBatchHttpRequests(array $requests)
    {
        $requests = array_map(
            function ($request) {
                /**
                 * @var RequestInterface $request
                 */
                return $this->client->createRequest(
                    $request->getMethod(),
                    (string)$request->getUri(),
                    ['headers' => $request->getHeaders()]
                );
            },
            $requests
        );

        return $requests;
    }

    /**
     * @param $oauthUri
     * @param $clientId
     * @param $clientSecret
     * @param $formParams
     * @return ResponseInterface
     */
    public function authenticate($oauthUri, $clientId, $clientSecret, $formParams)
    {
        $options = [
            'allow_redirects' => false,
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 10,
            'body' => $formParams,
            'auth' => [$clientId, $clientSecret]
        ];

        try {
            $response = $this->client->post($oauthUri, $options);
        } catch (RequestException $exception) {
            $authRequest = $exception->getRequest();
            $request = new Request(
                $authRequest->getMethod(),
                $authRequest->getUrl(),
                $authRequest->getHeaders(),
                (string)$authRequest->getBody()
            );
            $response = $this->packResponse($exception->getResponse());
            throw SphereException::create($request, $response);
        }
        return $response;
    }

    /**
     * @param RequestInterface $request
     * @return AdapterPromiseInterface
     */
    public function future(RequestInterface $request)
    {
        $options = [
            'allow_redirects' => false,
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 10,
            'future' => true,
            'exceptions' => false,
            'headers' => $request->getHeaders()
        ];
        $request = $this->client->createRequest($request->getMethod(), (string)$request->getUri(), $options);
        $guzzlePromise = $this->client->send($request, $options);

        $promise = new Guzzle5Promise($guzzlePromise);
        $promise->then(
            function (\GuzzleHttp\Message\ResponseInterface $response) {
                return new Response(
                    $response->getStatusCode(),
                    $response->getHeaders(),
                    (string)$response->getBody(),
                    $response->getProtocolVersion(),
                    $response->getReasonPhrase()
                );
            }
        );

        return $promise;
    }
}
