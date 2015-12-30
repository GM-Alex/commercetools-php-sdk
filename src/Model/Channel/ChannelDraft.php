<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Model\Channel;

use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Model\Common\JsonObject;
use Commercetools\Core\Model\Common\LocalizedString;

/**
 * @package Commercetools\Core\Model\Channel
 * @method string getKey()
 * @method ChannelDraft setKey(string $key = null)
 * @method array getRoles()
 * @method ChannelDraft setRoles(array $roles = null)
 * @method LocalizedString getName()
 * @method ChannelDraft setName(LocalizedString $name = null)
 * @method LocalizedString getDescription()
 * @method ChannelDraft setDescription(LocalizedString $description = null)
 */
class ChannelDraft extends JsonObject
{
    public function fieldDefinitions()
    {
        return [
            'key' => [static::TYPE => 'string'],
            'roles' => [static::TYPE => 'array'],
            'name' => [static::TYPE => '\Commercetools\Core\Model\Common\LocalizedString'],
            'description' => [static::TYPE => '\Commercetools\Core\Model\Common\LocalizedString'],
        ];
    }

    /**
     * @param string $key
     * @param Context|callable $context
     * @return ChannelDraft
     */
    public static function ofKey($key, $context = null)
    {
        return static::of($context)->setKey($key);
    }
}