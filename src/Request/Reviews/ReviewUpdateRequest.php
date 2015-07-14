<?php
/**
 * @author @ct-jensschulze <jens.schulze@commercetools.de>
 */

namespace Sphere\Core\Request\Reviews;

use Sphere\Core\Model\Common\Context;
use Sphere\Core\Request\AbstractUpdateRequest;
use Sphere\Core\Model\Review\Review;
use Sphere\Core\Response\ApiResponseInterface;

/**
 * Class ReviewUpdateRequest
 * @package Sphere\Core\Request\Reviews
 * @link http://dev.sphere.io/http-api-projects-reviews.html#update-review
 * @method Review mapResponse(ApiResponseInterface $response)
 */
class ReviewUpdateRequest extends AbstractUpdateRequest
{
    protected $resultClass = '\Sphere\Core\Model\Review\Review';

    /**
     * @param string $id
     * @param string $version
     * @param array $actions
     * @param Context $context
     */
    public function __construct($id, $version, array $actions = [], Context $context = null)
    {
        parent::__construct(ReviewsEndpoint::endpoint(), $id, $version, $actions, $context);
    }

    /**
     * @param string $id
     * @param int $version
     * @param Context $context
     * @return static
     */
    public static function ofIdAndVersion($id, $version, Context $context = null)
    {
        return new static($id, $version, [], $context);
    }
}
