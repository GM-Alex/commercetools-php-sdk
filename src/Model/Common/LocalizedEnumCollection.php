<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Model\Common;

/**
 * @package Commercetools\Core\Model\Common
 *
 * @method LocalizedEnum current()
 * @method LocalizedEnumCollection add(LocalizedEnum $element)
 * @method LocalizedEnum getAt($offset)
 */
class LocalizedEnumCollection extends Collection
{
    protected $type = '\Commercetools\Core\Model\Common\LocalizedEnum';
}