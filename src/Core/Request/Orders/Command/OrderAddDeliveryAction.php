<?php
/**
 * @author @jenschude <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Request\Orders\Command;

use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Model\Order\DeliveryItemCollection;
use Commercetools\Core\Model\Order\ParcelCollection;
use Commercetools\Core\Model\Order\ParcelMeasurements;
use Commercetools\Core\Model\Order\TrackingData;
use Commercetools\Core\Request\AbstractAction;

/**
 * @package Commercetools\Core\Request\Orders\Command
 * @link https://docs.commercetools.com/http-api-projects-orders.html#add-delivery
 * @method string getAction()
 * @method OrderAddDeliveryAction setAction(string $action = null)
 * @method DeliveryItemCollection getItems()
 * @method OrderAddDeliveryAction setItems(DeliveryItemCollection $items = null)
 * @method ParcelCollection getParcels()
 * @method OrderAddDeliveryAction setParcels(ParcelCollection $parcels = null)
 * @method ParcelMeasurements getMeasurements()
 * @method OrderAddDeliveryAction setMeasurements(ParcelMeasurements $measurements = null)
 * @method TrackingData getTrackingData()
 * @method OrderAddDeliveryAction setTrackingData(TrackingData $trackingData = null)
 */
class OrderAddDeliveryAction extends AbstractAction
{
    public function fieldDefinitions()
    {
        return [
            'action' => [static::TYPE => 'string'],
            'items' => [static::TYPE => DeliveryItemCollection::class],
            'parcels' => [static::TYPE => ParcelCollection::class],
            'measurements' => [static::TYPE => ParcelMeasurements::class],
            'trackingData' => [static::TYPE => TrackingData::class],
        ];
    }

    /**
     * @param array $data
     * @param Context|callable $context
     */
    public function __construct(array $data = [], $context = null)
    {
        parent::__construct($data, $context);
        $this->setAction('addDelivery');
    }

    /**
     * @param DeliveryItemCollection $items
     * @param Context|callable $context
     * @return OrderAddDeliveryAction
     */
    public static function ofDeliveryItems(DeliveryItemCollection $items, $context = null)
    {
        return static::of($context)->setItems($items);
    }
}
