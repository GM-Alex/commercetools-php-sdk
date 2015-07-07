<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Request\ShippingMethods\Command;

use Sphere\Core\Model\Common\Context;
use Sphere\Core\Model\ShippingMethod\ShippingRate;
use Sphere\Core\Model\Zone\ZoneReference;
use Sphere\Core\Request\AbstractAction;

/**
 * Class ShippingMethodAddShippingRateAction
 * @package Sphere\Core\Request\ShippingMethods\Command
 * 
 * @method string getAction()
 * @method ShippingMethodAddShippingRateAction setAction(string $action = null)
 * @method ZoneReference getZone()
 * @method ShippingMethodAddShippingRateAction setZone(ZoneReference $zone = null)
 * @method ShippingRate getShippingRate()
 * @method ShippingMethodAddShippingRateAction setShippingRate(ShippingRate $shippingRate = null)
 */
class ShippingMethodAddShippingRateAction extends AbstractAction
{
    public function getFields()
    {
        return [
            'action' => [static::TYPE => 'string'],
            'zone' => [static::TYPE => '\Sphere\Core\Model\Zone\ZoneReference'],
            'shippingRate' => [static::TYPE => '\Sphere\Core\Model\ShippingMethod\ShippingRate'],
        ];
    }

    /**
     * @param array $data
     * @param Context|callable $context
     */
    public function __construct(array $data = [], $context = null)
    {
        parent::__construct($data, $context);
        $this->setAction('addShippingRate');
    }

    /**
     * @param ZoneReference $zone
     * @param ShippingRate $shippingRate
     * @param Context|callable $context
     * @return ShippingMethodAddShippingRateAction
     */
    public static function ofZoneAndShippingRate(ZoneReference $zone, ShippingRate $shippingRate, $context = null)
    {
        return static::of($context)->setZone($zone)->setShippingRate($shippingRate);
    }
}
