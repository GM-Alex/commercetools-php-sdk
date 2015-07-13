<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Model\Order;

use Sphere\Core\Model\Common\Collection;

/**
 * Class ParcelCollection
 * @package Sphere\Core\Model\Order
 * 
 * @method Parcel current()
 * @method Parcel getAt($offset)
 */
class ParcelCollection extends Collection
{
    protected $type = '\Sphere\Core\Model\Order\Parcel';
}
