<?php
/**
 * @author @jenschude <jens.schulze@commercetools.de>
 * @created: 12.02.15, 14:18
 */

namespace Commercetools\Core\Request\Customers;

use Commercetools\Core\Client\HttpMethod;
use Commercetools\Core\Client\JsonRequest;
use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Request\AbstractApiRequest;
use Commercetools\Core\Response\ApiResponseInterface;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Response\ResourceResponse;
use Psr\Http\Message\ResponseInterface;
use Commercetools\Core\Model\MapperInterface;

/**
 * @package Commercetools\Core\Request\Customers
 * @link https://docs.commercetools.com/http-api-projects-customers.html#verify-customers-email
 * @method Customer mapResponse(ApiResponseInterface $response)
 * @method Customer mapFromResponse(ApiResponseInterface $response, MapperInterface $mapper = null)
 */
class CustomerEmailConfirmRequest extends AbstractApiRequest
{
    protected $resultClass = Customer::class;

    const TOKEN_VALUE = 'tokenValue';

    /**
     * @var string
     */
    protected $tokenValue;

    /**
     * @param string $tokenValue
     * @param Context $context
     */
    public function __construct($tokenValue, Context $context = null)
    {
        parent::__construct(CustomersEndpoint::endpoint(), $context);
        $this->tokenValue = $tokenValue;
    }

    /**
     * @param string $tokenValue
     * @param Context $context
     * @return static
     */
    public static function ofToken($tokenValue, Context $context = null)
    {
        return new static($tokenValue, $context);
    }

    /**
     * @return string
     * @internal
     */
    protected function getPath()
    {
        return (string)$this->getEndpoint() . '/email/confirm' .  $this->getParamString();
    }

    /**
     * @return JsonRequest
     * @internal
     */
    public function httpRequest()
    {
        $payload = [
            static::TOKEN_VALUE => $this->tokenValue,
        ];
        return new JsonRequest(HttpMethod::POST, $this->getPath(), $payload);
    }

    public function buildResponse(ResponseInterface $response)
    {
        return new ResourceResponse($response, $this, $this->getContext());
    }
}
