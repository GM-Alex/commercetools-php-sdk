<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Request\Products;


use Sphere\Core\Client\HttpMethod;
use Sphere\Core\Model\Product\Facet;
use Sphere\Core\Model\Product\Filter;
use Sphere\Core\RequestTestCase;

class ProductsSearchRequestTest extends RequestTestCase
{
    const PRODUCT_SEARCH_REQUEST = '\Sphere\Core\Request\Products\ProductsSearchRequest';

    public function testMapResult()
    {
        $data = [
            'results' => [
                ['id' => 'value'],
                ['id' => 'value'],
                ['id' => 'value'],
            ]
        ];
        $result = $this->mapQueryResult(ProductsSearchRequest::of(), [], $data);
        $this->assertInstanceOf('\Sphere\Core\Model\Product\ProductProjectionCollection', $result);
    }

    public function testMapEmptyResult()
    {
        $result = $this->mapEmptyResult(ProductsSearchRequest::of());
        $this->assertInstanceOf('\Sphere\Core\Model\Product\ProductProjectionCollection', $result);
    }

    public function testAddFilterString()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilter(Filter::ofType('string')->setName('key')->setValue('value'));
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search?filter=key%3A%22value%22', (string)$httpRequest->getUri());
    }

    public function testAddMultiFilterString()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilter(Filter::ofType('string')->setName('key')->setValue('value'));
        $request->addFilter(Filter::ofType('string')->setName('foo')->setValue('bar'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?filter=foo%3A%22bar%22&filter=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testAddFilterInt()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilter(Filter::ofType('int')->setName('key')->setValue(10));
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search?filter=key%3A10', (string)$httpRequest->getUri());
    }

    public function testAddFilterArray()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilter(Filter::ofType('array')->setName('key')->setValue([10,20,30]));
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search?filter=key%3A10%2C20%2C30', (string)$httpRequest->getUri());
    }

    public function testAddFilterQuery()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilterQuery(Filter::ofType('string')->setName('key')->setValue('value'));
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search?filter.query=key%3A%22value%22', (string)$httpRequest->getUri());
    }

    public function testAddFilterQueryFacet()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilterQuery(Filter::ofType('string')->setName('key')->setValue('value'));
        $request->addFacet(Facet::of('string')->setName('key')->setValue('value'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?facet=key%3A%22value%22&filter.query=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testAddMultiFilterQuery()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilterQuery(Filter::ofType('string')->setName('key')->setValue('value'));
        $request->addFilterQuery(Filter::ofType('string')->setName('foo')->setValue('bar'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?filter.query=foo%3A%22bar%22&filter.query=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testAddFilterFacets()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilterFacets(Filter::ofType('string')->setName('key')->setValue('value'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?filter.facets=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testAddMultiFilterFacets()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFilterFacets(Filter::ofType('string')->setName('key')->setValue('value'));
        $request->addFilterFacets(Filter::ofType('string')->setName('foo')->setValue('bar'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?filter.facets=foo%3A%22bar%22&filter.facets=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testAddFacet()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFacet(Facet::ofType('string')->setName('key')->setValue('value'));
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search?facet=key%3A%22value%22', (string)$httpRequest->getUri());
    }

    public function testAddMultiFacet()
    {
        /**
         * @var ProductsSearchRequest $request
         */
        $request = ProductsSearchRequest::of();
        $request->addFacet(Facet::ofType('string')->setName('key')->setValue('value'));
        $request->addFacet(Facet::ofType('string')->setName('foo')->setValue('bar'));
        $httpRequest = $request->httpRequest();

        $this->assertSame(
            '/product-projections/search?facet=foo%3A%22bar%22&facet=key%3A%22value%22',
            (string)$httpRequest->getUri()
        );
    }

    public function testHttpRequestMethod()
    {
        $request = ProductsSearchRequest::of();
        $httpRequest = $request->httpRequest();

        $this->assertSame(HttpMethod::GET, $httpRequest->getMethod());
    }

    public function testHttpRequestPath()
    {
        $request = ProductsSearchRequest::of();
        $httpRequest = $request->httpRequest();

        $this->assertSame('/product-projections/search', (string)$httpRequest->getUri());
    }

    public function testHttpRequestObject()
    {
        $request = ProductsSearchRequest::of();
        $httpRequest = $request->httpRequest();

        $this->assertEmpty((string)$httpRequest->getBody());
    }

    public function testBuildResponse()
    {
        $guzzleResponse = $this->getMock('\GuzzleHttp\Psr7\Response', [], [], '', false);
        $request = ProductsSearchRequest::of();
        $response = $request->buildResponse($guzzleResponse);

        $this->assertInstanceOf('\Sphere\Core\Response\PagedQueryResponse', $response);
    }
}
