<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\Core\CartDiscount;


use Commercetools\Core\ApiTestCase;
use Commercetools\Core\Model\CartDiscount\CartDiscount;
use Commercetools\Core\Model\CartDiscount\CartDiscountDraft;
use Commercetools\Core\Model\CartDiscount\CartDiscountTarget;
use Commercetools\Core\Model\CartDiscount\CartDiscountValue;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\MoneyCollection;
use Commercetools\Core\Request\CartDiscounts\CartDiscountByIdGetRequest;
use Commercetools\Core\Request\CartDiscounts\CartDiscountCreateRequest;
use Commercetools\Core\Request\CartDiscounts\CartDiscountDeleteRequest;
use Commercetools\Core\Request\CartDiscounts\CartDiscountQueryRequest;

class CartDiscountQueryRequestTest extends ApiTestCase
{
    /**
     * @return CartDiscountDraft
     */
    protected function getDraft()
    {
        $draft = CartDiscountDraft::ofNameValuePredicateTargetOrderActiveAndDiscountCode(
            LocalizedString::ofLangAndText('en', 'test-' . $this->getTestRun() . '-discount'),
            CartDiscountValue::of()->setType('absolute')->setMoney(
                MoneyCollection::of()->add(Money::ofCurrencyAndAmount('EUR', 100))
            ),
            '1=1',
            CartDiscountTarget::of()->setType('lineItems')->setPredicate('1=1'),
            '0.9' . trim((string)mt_rand(1, 1000), '0'),
            true,
            false
        );

        return $draft;
    }

    protected function createCartDiscount(CartDiscountDraft $draft)
    {
        /**
         * @var CartDiscount $cartDiscount
         */
        $response = $this->getClient()
            ->execute(CartDiscountCreateRequest::ofDraft($draft));

        $cartDiscount = $response->toObject();

        $this->cleanupRequests[] = CartDiscountDeleteRequest::ofIdAndVersion(
            $cartDiscount->getId(),
            $cartDiscount->getVersion()
        );

        return $cartDiscount;
    }

    public function testQueryByName()
    {
        $draft = $this->getDraft();
        $cartDiscount = $this->createCartDiscount($draft);

        $result = $this->getClient()->execute(
            CartDiscountQueryRequest::of()->where('name(en="' . $draft->getName()->en . '")')
        )->toObject();

        $this->assertCount(1, $result);
        $this->assertInstanceOf('\Commercetools\Core\Model\CartDiscount\CartDiscount', $result->getAt(0));
        $this->assertSame($cartDiscount->getId(), $result->getAt(0)->getId());
    }

    public function testQueryById()
    {
        $draft = $this->getDraft();
        $cartDiscount = $this->createCartDiscount($draft);

        $result = $this->getClient()->execute(CartDiscountByIdGetRequest::ofId($cartDiscount->getId()))->toObject();

        $this->assertInstanceOf('\Commercetools\Core\Model\CartDiscount\CartDiscount', $cartDiscount);
        $this->assertSame($cartDiscount->getId(), $result->getId());

    }
}
