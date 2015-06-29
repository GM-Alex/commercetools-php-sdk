<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Model\Common;

/**
 * Class Set
 * @package Sphere\Core\Model\Common
 * @link http://dev.sphere.io/http-api-projects-products.html#product-variant-attribute
 */
class Set extends Collection
{
    /**
     * @param $type
     * @param Context|callable $context
     * @return $this
     */
    public static function ofType($type, $context = null)
    {
        $set = static::of($context);
        return $set->setType($type);
    }

    public function __toString()
    {
        $values = [];
        foreach ($this as $set) {
            $values[] = (string)$set;
        }
        return implode(', ', $values);
    }
}
