<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Request\Carts\Command;

use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Request\AbstractAction;

/**
 * @package Commercetools\Core\Request\Carts\Command
 * @link https://dev.commercetools.com/http-api-projects-carts.html#remove-lineitem
 * @method string getAction()
 * @method CartRemoveLineItemAction setAction(string $action = null)
 * @method string getLineItemId()
 * @method CartRemoveLineItemAction setLineItemId(string $lineItemId = null)
 * @method int getQuantity()
 * @method CartRemoveLineItemAction setQuantity(int $quantity = null)
 */
class CartRemoveLineItemAction extends AbstractAction
{
    public function fieldDefinitions()
    {
        return [
            'action' => [static::TYPE => 'string'],
            'lineItemId' => [static::TYPE => 'string'],
            'quantity' => [static::TYPE => 'int'],
        ];
    }

    /**
     * @param array $data
     * @param Context|callable $context
     */
    public function __construct(array $data = [], $context = null)
    {
        parent::__construct($data, $context);
        $this->setAction('removeLineItem');
    }

    /**
     * @param $lineItemId
     * @param Context|callable $context
     * @return CartRemoveLineItemAction
     */
    public static function ofLineItemId($lineItemId, $context = null)
    {
        return static::of($context)->setLineItemId($lineItemId);
    }
}