<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */
namespace Commercetools\Generator;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class JsonResource
{
    /**
     * @var string
     */
    public $type;
}
